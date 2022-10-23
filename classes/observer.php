<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * local_chature file description here.
 *
 * @package    local_chature
 * @copyright  2022 aadar <@link aadarshadhakal.com.np>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class local_chature_observer
{
    public  static function process_discussion(\mod_forum\event\assessable_uploaded $event){
        global $DB;
        $post = forum_get_post_full($event->objectid);
        $postid = $post->id;
        $forum = $DB->get_record('forum', array('id' => $post->forum), '*', MUST_EXIST);
        $discussion = $DB->get_record('forum_discussions',
            array('id' => $post->discussion), '*', MUST_EXIST);

        if($discussion->firstpost == $postid) {
            $course = $discussion->course;
            $exttoken = get_config("local_chature", "apikey");
            $acctoken = get_config("local_chature", "accesstoken");
            $glueendpoint = get_config("local_chature", "glueendpoint");
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "$glueendpoint/moodleglue/process/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\t\"post_id\":$postid,\n\t\"token\":\"$acctoken\",\n\t\"course\":$course\n}",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Token $exttoken",
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }

    }

}