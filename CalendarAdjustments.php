<?php


class CalendarAdjustments {

    public function __construct($order)
    {
        $this->name = $order['post_title'];
        $this->description = $order['description'];
        $this->post_type = 'ai1ec_event';

        $this->guid = get_site_url() . '/event/';


        //All In One Event Calendar demands that a date and the corresponding time is saved in seconds.
        $this->start = strtotime($order['start']);
        $this->end = strtotime($order['end']);


        //Standard Timezone chosen due to the scope of the project
        $this->timezone ="Europe/Amsterdam";

        $this->venue = $order['venue'];

        //Extra options that need to be defined for the query, not  necessary for the scope of this project
        $this->instant = 0;
        $this->allday = 0;
        $this->force_regenerate = 0;

        //Default post_status has to be published else it won't be seen in the plugin
        $this->post_status ="publish";

        // Converting a string to a slug friendly URL for a WordPress title e.g Title Name Is -> title-name-is
        $this->slug = sanitize_title($order['post_title']);

    }



    //Global class to interact with all the records
    public function dbInteractions(){

        //Only enable when testing
//        global $wpdb;
//        $wpdb->show_errors();

        //Excecuting the post_id first due to it's necessity in other query's
        $this->dbWPPost();

//        //Event_id is done second due to it being a paramater to event_instance
        $this->dbEvents();

//        // //After the post_id and event_id are known, both values can be used for this database record
        $this->dbEventInstance();
    }

    public function dbWPPost()
    {

        //Returning post_id for later uses
      $this->post_id = wp_insert_post(array(
            "post_date" => date('Y-m-d H:i:s'),
            "post_date_gmt" => gmdate('Y-m-d H:i:s'),
            "post_title" => $this->name,
            "guid" =>   $this->guid . $this->slug,
            "post_type" =>$this->post_type,
            "post_content" =>$this->description,
            "post_status" => $this->post_status
        ));
    }

    public function dbEvents(){
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'ai1ec_events', array(
            'post_id' => $this->post_id,
            'start' => $this->start,
            'end' => $this->end,
            'timezone_name' => $this->timezone,
            'instant_event' => $this->instant,
            'allday' => $this->allday,
            'force_regenerate' => $this->force_regenerate
        ));
        $this->event_id = $wpdb->insert_id;
    }


    public function dbEventInstance(){
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'ai1ec_event_instances', array(
            'id' => $this->event_id,
            'post_id' => $this->post_id,
            'start' => $this->start,
            'end' => $this->end
        ));
    }
}




