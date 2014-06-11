<?php

class Theme
{
    public $keywords;
    //private $keyword_id;
    private $name;
    private $theme_id;
    private $keyword_id;


    function Theme($name = NULL)
    {
        if ($name == NULL) {
            //we're creating
        } else {
            //we're loading from the database
            $this->name = $name;
            $sql = sprintf("SELECT * FROM themes WHERE theme_id = '%s'", $this->name);
            $result = DBHandler::do_query($sql);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $data = mysqli_fetch_assoc($result);
                    $this->theme_id = $data['theme_id'];
                    $this->name = $data['name'];

                }
            }

        }

    }





    public function add_keyword_to_theme($theme_namepw, $strings)
    {

        /*
         * 1. Obtain the theme_id value from the current theme.
         * 2. Check to see if the keyword is already in the database
         * 3.   If yes, get the keyword id, from the keyword table,
         *      add keyword_id and theme_id values to theme_to_keywords table
         *
         * 4. If no, create keyword in keyword table. grab keyword_id,
         *      insert keyword_id & theme_id value to theme_to_keywords table
         *
         */

        foreach($strings as $string){






        $find_theme_id_sql = sprintf("SELECT * from themes WHERE name = '%s'", $theme_namepw);
        $result = DBHandler::do_query($find_theme_id_sql);
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
                $this->set_id($data['theme_id']);
                file_put_contents('theme_id.txt', $this->get_id());
            }

        }
        $check_for_kw_sql = sprintf("SELECT id from keywords WHERE keyword = '%s'", $string);
        $kw_chk_results = DBHandler::do_query($check_for_kw_sql);
        if (mysqli_num_rows($kw_chk_results) > 0) {
            //keyword already exists so we will just add it to the themes list
            $row = mysqli_fetch_assoc($kw_chk_results);
            $keyword_id = $row['id'];

            file_put_contents('keywordid.txt', $this->get_keyword_id());
            $sql = sprintf("INSERT into themes_keywords(th_kwid, theme_id, keyword_id) VALUES (NULL, '%s', '%s')", $this->theme_id, $keyword_id);
            $result = DBHandler::do_query($sql);

        } else {
            //keyword doesn't exist. Create it then add to themes_keywords
            $sql = sprintf("INSERT into keywords(id, keyword) VALUES (NULL, '%s')", $string);
            $result = DBHandler::do_query($sql);

            $check_for_kw_sql = sprintf("SELECT id from keywords WHERE keyword = '%s'", $string);
            $kw_chk_results = DBHandler::do_query($check_for_kw_sql);
            $row = mysqli_fetch_assoc($kw_chk_results);
            $keyword_id = $row['id'];

            $sql2 = sprintf("INSERT into themes_keywords(th_kwid, theme_id, keyword_id) VALUES (NULL, '%s', '%s')", $this->theme_id, $keyword_id);
            $result2 = DBHandler::do_query($sql2);
            file_put_contents('themeidandkeywordid.txt', $this->get_id() . 'boom' . $keyword_id);

        }
        }
    }


    public function remove_keyword_from_theme($string)
    {

        //remove keyword from theme_keywords; need to use this->theme_id;

        $sql = sprintf("DELETE from themes_keywords * WHERE keyword = '%s' AND theme_id = '%s'", $string, $this->theme_id);
        $result = DBHandler::do_query($sql);

    }


    public static function delete_theme_using_id($theme_id)
    {
        $sql = sprintf("DELETE * from themes WHERE theme_id = '%s'", $theme_id);
        DBHandler::do_query($sql);
    }

    public static function delete_theme_using_name($theme_name){
        $sql = sprintf("DELETE * from themes WHERE name = '%s'", $theme_name);
        DBHandler::do_query($sql);
    }

    function get_all_themes()
    {
        $themes = array();
        $sql = sprintf("SELECT * from themes");
        $result = DBHandler::do_query($sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    $themes[] = new Theme($data['name']);
                }
            }
            return $themes;
        }
    }


    public  function get_keywords_relating_to_theme($theme_name){
                /*
         * 1. GET THEME ID (SELECT ID FROM themes
         * 2. SELECT ALL keyword_id from theme_keywords WHERE theme_id = $theme_id
         * 3. data=mysqli_fetch_assoc
         */

        $sql = sprintf("SELECT theme_id from themes WHERE name = '%s'", $theme_name);
        $result = DBHandler::do_query($sql);
        $data = mysqli_fetch_assoc($result);
        $theme_id = $data['theme_id'];

        $sql = sprintf("SELECT themes_keywords.keyword_id, keywords.keyword
                        FROM themes_keywords, keywords
                        WHERE keywords.id = themes_keywords.keyword_id
                        AND theme_id = '%s' ORDER BY themes_keywords.keyword_id", $theme_id);
        $result = DBHandler::do_query($sql);
        while($data=mysqli_fetch_assoc($result)){
            $keyword_array= $data['keyword'];

            $this->set_keyword($data['keyword']);
            file_put_contents('keywordsearchstring.txt', $this->keywords );
        }


return $this->keywords;



    }






//    public static function get_keywords_relatiing_to_theme($theme_name){
//        /*
//         * 1. GET THEME ID (SELECT ID FROM themes
//         * 2. SELECT ALL keyword_id from theme_keywords WHERE theme_id = $theme_id
//         * 3. data=mysqli_fetch_assoc
//         */
//
//     $sql = sprintf("SELECT theme_id from themes WHERE name = '%s'", $theme_name);
//        $result = DBHandler::do_query($sql);
//        $data = mysqli_fetch_assoc($result);
//        $theme_id = data['id'];
//
//        $bigsql =
//            sprintf("SELECT thk.theme_id, thk.keyword_id, kw.keyword
//            FROM themes_keywords thk, keywords kw,
//            WHERE theme_id = '%s'
//           ", $theme_id);
//
//
//        $result = DBHandler::do_query($sql);
//
//
//        //Iterate through resultset, grab all the keywords
//
///*$sql = sprintf("SELECT rv.uid, rv.bid, rv.cid, rv.date_posted, rv.content, rv.summary, rv.rating
//FROM users usr, reviews rv
//WHERE usr.username =  'gabrielw3'
//AND rv.uid = usr.uid
//ORDER BY date_posted desc", $bname);*/
//
//    }


    function find_articles_with_keywords_present($theme_name = NULL, $searchString)
    {
        /*
         * 1. Take in String of keywords that match the theme_id in DB
         * 2. Separate the keywords by spaces, so the entire string can be fed into the SQL search operation.
         * 4. Feed the result to a string
         * 5. Pass the string to search $sql, to be in "AGAINST" section
         */


      //file_put_contents('searchString.txt', $searchString);
        $sql = sprintf("SELECT `ID`,`title`, `description`, `content`,`pub_date` FROM entries WHERE MATCH(title, content) AGAINST('%s' IN BOOLEAN MODE)", $searchString);
        $result = DBHandler::do_query($sql);
       while ($data = mysqli_fetch_assoc($result)){
           \Theme::createOutputForTextAnalyzer($data);
            $article_id = $data['ID'];
           \Theme::map_article_to_theme($theme_name, $article_id);
       }
        \Theme::searchTime($this->get_theme_id_from_db($theme_name));

    }


    function searchTime($theme_id){

     $time = time();
    $sql = sprintf("INSERT into last_search(last_search_time, theme_id) VALUES('%s', '%s')", $time, $theme_id);
        DBHandler::do_query($sql);


    }


/*function incremental_search_for_articles($theme_name = null, $theme_id = null){
    if (!isset($theme_name){

    }else{

    }
    /*
     * 1. Check the theme id
     */
//}












    function mark_as_searched(){

    }

    function map_article_to_theme($theme_name, $article_id){

        $sql = sprintf("SELECT * FROM themes where name = '%s'", $theme_name);
        $result = DBHandler::do_query($sql);
        while($data = mysqli_fetch_assoc($result)){
            $theme_id = $data['theme_id'];
            $sql = sprintf("INSERT into theme_to_article(ttaid, theme_id, article_id) VALUES(null, '%s', '%s')", $theme_id, $article_id);
           DBHandler::do_query($sql);

            $time_found = time();
            $sql1 = sprintf("INSERT into found_in(fid, theme_id, article_id, time_found) VALUES(null, '%s','%s', '%s')", $theme_id, $article_id, $time_found);
            DBHandler::do_query($sql1);



        }




        /*
         * 1. Get theme ID
         * 2. each article found, get ID
         * 2. Store Article ID, themeID in article_to_theme table
         * 3. Store
         */



    }



    function insert()
    {
        $sql = sprintf("INSERT INTO themes(theme_id, name) VALUES(NULL, '%s')", $this->name);
        $result = DBHandler::do_query($sql);
        if ($result) {
            return true;
        }
        return false;
    }


    function set_name($name)
    {
        $this->name = $name;
    }

    function get_name()
    {
        return $this->name;
    }

    function set_id($id)
    {
        $this->theme_id = $id;
    }

    function get_id()
    {
        return $this->theme_id;
    }

    function get_theme_id_from_db($name){
       $sql=sprintf("SELECT theme_id from themes WHERE name = '%s'", $name);
        $result = DBHandler::do_query($sql);
        $data = mysqli_fetch_assoc($result);
        $id = $data['theme_id'];
        return $id;
    }

    function get_keywords()
    {
        return $this->keywords;
    }

    function get_keyword_id()
    {
        return $this->keyword_id;
    }

    function set_keyword($string)
    {
        $this->keywords.=' '.$string;
    }


    function createOutputForTextAnalyzer($data){
        $file = $data['ID']. '.json';

        $json_string ='{'. '"document":{"id":'. '"'.  $data['ID']. '"'.  ','.'"txt":'.  '"'.   strip_tags($data['description']. $data['content'])  .'"'. ','.  '"language":'. '"es,"' . '"source":'.  '"NEWS",' . '"timeref":'. '"'. $data['pub_date'] . ',' . '"'. '"itf":' . '"txt"'. '}';

        file_put_contents($file, $json_string, FILE_APPEND | LOCK_EX);

    }


}

?>

