<?php

namespace WonologSimplyHistory;

/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Cube starter theme
    Made by Rodesk B.V.
    E-mail  : joeriabbo@hotmail.com
    Website : https://www.linkedin.com/in/joeri-abbo-43a457144/

    File: Cube maillogger.php file
    This is the cube theme maillogger

-----------------------------------------------------------------------------------*/

if (class_exists('Simplelogger')){

    /**
     * Our logger is a class that extends the built in SimpleLogger-class
     */
    class WSHMailHandler extends Simplelogger {

        /**
         * The slug is used to identify this logger in various places.
         * We use the name of the class too keep it simple.
         * Please note that the slug must be max 30 chars long.
         */
        public $slug = __CLASS__;

        /**
         * Method that returns an array with information about this logger.
         * Simple History used this method to get info about the logger at various places.
         */
        function getInfo() {

            $arr_info = [
                "name" => "WP Mail Logger",
                "description" => "Logs mail sent by WordPress using the wp_mail function"
            ];

            return $arr_info;

        }

        /**
         * The loaded method is called automagically when Simple History is loaded.
         * Much of the init-code for a logger goes inside this method. To keep things
         * simple in this example, we add almost all our code inside this method.
         */
        function loaded() {

            /**
             * Use the "wp_mail" filter to log emails sent with wp_mail()
             */
            add_filter( 'wp_mail', [$this, "on_wp_mail"]);

        }

        function on_wp_mail($args) {

            $context = [
                "email_to"      => $args["to"],
                "email_subject" => $args["subject"],
                "email_message" => $args["message"]
            ];

            $this->info("Sent an email to '{email_to}' with subject '{email_subject}' using wp_mail()", $context);

            return $args;

        }

    }

}
