<?php 

/**
 * Plugin name: Releted Post
 * Description: This is my releted post plugin
 * Author: Muslim khan
 * 
 * 
 */

 class rp_releted_post {
     public function __construct() {
          add_action('init', array($this, 'initalize'));
     }


      function initalize() {
        add_filter('the_content', array($this, 'change_content'));   //hook     
     }    


    public function change_content($content) {

        if( ! is_singular( 'post' ) ){
            return $content;
        }
          
        $currentcat = get_the_category(get_the_ID());   // Returns the category information associated with the current post

        $currentcat = wp_list_pluck($currentcat, 'term_id');  //convert the array of id to string

        $currentcat = implode( ', ', $currentcat );   

        $arrg = array(
            "post_type" => "post", // Setting 'post' as post type
            'cat' => $currentcat,
            'orderby' => 'rand',     // Posts will be decorated randomly
            'posts_per_page' => 3    // 5 posts will be displayed per page         
        );

            
        // the query.
        $the_query = new WP_Query( $arrg ); 
        
            if ( $the_query->have_posts()) {

                $content.= '<div class="main_div">';

                while( $the_query->have_posts() ) :    //loop
                    $the_query->the_post();
                    $content.='<b>'.get_the_title().'</b>'. '<br>';
                    $content.= get_the_post_thumbnail();
                    $content.='<p>'.get_the_content().'</p>';
                    
                endwhile;

                $content.='</div>';


                wp_reset_postdata();  //Resets the global post data to the original main query
        
            } else {
            echo 'no post';

        }
        return $content;
    }          
} 
new  rp_releted_post();   


















































 