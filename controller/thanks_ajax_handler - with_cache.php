<?php
/**
*
* @author Sergeiy Varzaev (Палыч)  phpbbguru.net varzaev@mail.ru
* @version $Id: toplist.php,v 135 2012-10-10 10:02:51 Палыч $
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace gfksx\thanks_for_posts\controller;

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

class thanks_ajax_handler
{
protected $thankers = array();
   public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver $db, \phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user, \phpbb\cache\driver\driver_interface $cache, $phpbb_root_path, $php_ext, \phpbb\controller\helper $helper, $phpbb_container, $gfksx_helper, \phpbb\request\request_interface $request, $table_prefix)
    {
		$this->config = $config;
		$this->db = $db;
		$this->auth = $auth;
        $this->template = $template;
        $this->user = $user;
		$this->cache = $cache;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->helper = $helper;
		$this->phpbb_container = $phpbb_container;
		$this->gfksx_helper = $gfksx_helper;
		$this->request = $request;
        $this->return = array(); // save returned data in here
        $this->error = array(); // save errors in here
    }

	public function main($action, $poster, $forum, $topic, $post)
	{
		// Grab data
        switch ($action)
        {
            case 'thanks':
            case 'rthanks':
                $this->thanks_for_post($action, $poster, $forum, $topic, $post);
            break;
                 case 'clear_thanks':
					$this->clear_list_thanks($poster, $forum, $topic, $post);
				break;                           
           
            default:
                $this->error[] = $this->user->lang['INCORRECT_THANKS'];	
            

        }
        if (sizeof($this->error))
        {
  		    $json_response = new \phpbb\json_response;
		    $json_response->send($this->error);
        }
        else
        {
 		    $json_response = new \phpbb\json_response;
		    $json_response->send($this->return);
        }
	



	}
    
    private function thanks_for_post($action, $poster_id, $forum_id, $topic_id, $post_id)
    {
		$this->user->add_lang_ext('gfksx/thanks_for_posts', 'thanks_mod');
            $user_id = (int)$this->user->data['user_id'];
            $this->thankers = $this->gfksx_helper->cache->get('_thankers');
            if ($this->user->data['user_type'] != USER_IGNORE && !empty($poster_id))
	        {
                switch ($action)
                {
                    case 'thanks':
		                if ($poster_id != $user_id  && !$this->already_thanked($post_id, $user_id) && ($this->auth->acl_get('f_thanks', $forum_id) || (!$forum_id && (isset($this->config['thanks_global_post']) ? $this->config['thanks_global_post'] : false))) )
		                { 
                            //add to thankers
                            $thanks_time = time();
                            $this->user->data['user_id'];
                            $j = sizeof($this->thankers);
                            $this->thankers[$j] = array(  
					            'user_id' 			=>$user_id,
					            'poster_id' 		=> $poster_id,
					            'post_id' 			=> $post_id,
					            'thanks_time'		=> $thanks_time,
					            'username'			=> $this->user->data['username'],
					            'username_clean'	=> $this->user->data['username_clean'],
					            'user_colour'		=> $this->user->data['user_colour'],
				            );
                            $this->gfksx_helper->cache->put('_thankers', $this->thankers);        
                            //print_r('res = ' . $this->already_thanked($post_id, $user_id));
                            
                            //add to DB
			                $sql = 'INSERT INTO ' . THANKS_TABLE . ' ' . $this->db->sql_build_array('INSERT', array(
				                'user_id'	=> $user_id,
				                'post_id'	=> $post_id,
				                'poster_id'	=> $poster_id,
				                'topic_id'	=> $topic_id,
				                'forum_id'	=> $forum_id,
				                'thanks_time'	=> $thanks_time,
			                ));
			                $this->db->sql_query($sql); 
	                    }           
 	                    else
		                {
                            $this->error = $this->user->lang['GLOBAL_INCORRECT_THANKS'];	
                        }
                        break;
                    case 'rthanks':
                        if (isset($this->config['remove_thanks']) ? !$this->config['remove_thanks'] : true)
	                    {
                            $this->error =  $this->user->lang['DISABLE_REMOVE_THANKS'];	
                            return;
                            
	                    }   

                        //delete thanker from cache
                        $key = $this->get_key_by_post($post_id, $user_id);
                        if ( $key)
                        {
                            unset($this->thankers[$key]);
                            $this->gfksx_helper->cache->put('_thankers', $this->thankers);        
                        }
                            
                        $sql = "DELETE FROM " . THANKS_TABLE . '
                                        WHERE post_id ='.  $post_id ." AND user_id = " . (int) $user_id;
                                    $this->db->sql_query($sql);
                                    $result = $this->db->sql_affectedrows($sql);
                        if ($result == 0)
                        {
                            $this->error =$this->user->lang['INCORRECT_THANKS'];	
                        }
                        
                        break; 
                    default:
                    
                    
                }//end switch
            }

            //calculate_new_post_rating
  
                //max post thanks
                if (isset($this->config['thanks_post_reput_view']) ? $this->config['thanks_post_reput_view'] : false)
                {
                    $sql = 'SELECT MAX(tally) AS max_post_thanks
                        FROM (SELECT post_id, COUNT(*) AS tally FROM ' . THANKS_TABLE . ' GROUP BY post_id) t';
                    $result = $this->db->sql_query($sql);
                    $max_post_thanks = (int) $this->db->sql_fetchfield('max_post_thanks');
                    $this->db->sql_freeresult($result);
                }
                else
                {
                $max_post_thanks = 1;
                }
                //give-receive counters
                $sql = 'SELECT  (select count(user_id) FROM ' . THANKS_TABLE .  ' WHERE user_id=' . $user_id . ') give, ' .
                            '  (select count(poster_id)     FROM  ' . THANKS_TABLE .  ' WHERE  poster_id = ' . $poster_id . ') rcv ';
                        $result = $this->db->sql_query($sql);
                    $row_giv_rcv = $this->db->sql_fetchrow($result);
                    $poster_give_count = $row_giv_rcv['give'];                    
                    $poster_receive_count = $row_giv_rcv['rcv'];                    
                $this->db->sql_freeresult($result);

                $thanks_number = $this->get_thanks_number($post_id);
                $post_reput = ($thanks_number != 0) ? round($thanks_number / ($max_post_thanks / 100), $config['thanks_number_digits']) . '%' : '';
                $lang_act = $action == 'thanks' ?  'GIVE' : 'REMOVE';
			    if (isset($config ['thanks_notice_on']) ? $config ['thanks_notice_on'] : false)
			    {
                    //todo
                    //send_thanks_pm($user_id, $poster_id, $send_pm = true, $post_id, $lang_act);
                    //send_thanks_email($poster_id, $post_id, $lang_act);
			    }	
                $poster_name = '';
                $poster_name_full =  '';
                $this->get_poster_details($poster_id, $poster_name, $poster_name_full);
                $action_togle = $action == 'thanks' ? 'rthanks' : 'thanks' ;
                $path = './app.php/thanks_for_posts/' . $action_togle . '/' . $poster_id . '/' . $forum_id . '/' . $topic_id . '/' . $post_id;
                $thank_alt = ($action == 'thanks' ? $this->user->lang['REMOVE_THANKS'] :  $this->user->lang['THANK_POST']) . $poster_name_full;
                $class_icon = $action == 'thanks' ? 'removethanks-icon' : 'thanks-icon';
                $thank_img = "<a  href='" .  $path . "'   data-ajax='togle_thanks' title='" . $thank_alt . "' class='button icon-button " .  $class_icon . "'><span>&nbsp;</span></a>";

                $message = $this->user->lang['THANKS_INFO_' . $lang_act];
               
                
		        $this->return = array(
			        'action'	=>$action,
                    'SUCCESS'	    => $message,	
                    'POST_REPUT'	    => $post_reput,	
                    'POST_ID'	            => $post_id,	
                    'POSTER_ID'	            => $poster_id,	
                    'USER_ID'	            => $this->user->data['user_id'],	
                    'CLASS_ICON'	            => $action == 'thanks' ? 'removethanks-icon' : 'thanks-icon',	
                    'S_THANKS_POST_REPUT_VIEW' 	=> isset($this->config['thanks_post_reput_view']) ? $this->config['thanks_post_reput_view'] : false,   
                    'THANK_ALT'		=> ($action == 'thanks' ? $this->user->lang['REMOVE_THANKS'] :  $this->user->lang['THANK_POST']) . $poster_name,
  			        'S_THANKS_REPUT_GRAPHIC' 	=> isset($this->config['thanks_reput_graphic']) ? $this->config['thanks_reput_graphic'] : false,
				    'THANKS_REPUT_GRAPHIC_WIDTH'=> isset($this->config['thanks_reput_level']) ? (isset($this->config['thanks_reput_height']) ? sprintf('%dpx', $this->config['thanks_reput_level']*$this->config['thanks_reput_height']) : false) : false,
		            'THANKS_REPUT_HEIGHT'		=> isset($this->config['thanks_reput_height']) ? sprintf('%dpx', $this->config['thanks_reput_height']) : false,
		            'THANKS_REPUT_IMAGE_BACK'	=> isset($this->config['thanks_reput_image_back']) ? $this->phpbb_root_path . $this->config['thanks_reput_image_back'] : '',	
		            'THANKS_REPUT_IMAGE' 		=> isset($this->config['thanks_reput_image']) ? $this->phpbb_root_path . $this->config['thanks_reput_image'] : '',
			        'THANKS'					=> $this->get_thanks($post_id),
				    'THANKS_POSTLIST_VIEW'		=> isset($this->config['thanks_postlist_view']) ? $this->config['thanks_postlist_view'] : false,
				    'S_MOD_THANKS'				=> $this->auth->acl_get('m_thanks'),
				    'U_CLEAR_LIST_THANKS_POST'	=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $forum_id . '&amp;p=' . $row['post_id'] . '&amp;list_thanks=post'),
 			        'S_POST_ANONYMOUS'			=> ($poster_id == ANONYMOUS) ? true : false,
				    'THANK_TEXT'				=> $this->user->lang['THANK_TEXT_1'],
				    'THANK_TEXT_2'				=> ($thanks_number != 1) ? sprintf($this->user->lang['THANK_TEXT_2PL'], $thanks_number) : $this->user->lang['THANK_TEXT_2'],
 		            'POST_AUTHOR_FULL'		    =>$poster_name_full,
				    'THANKS_COUNTERS_VIEW'		=> isset($this->config['thanks_counters_view']) ? $this->config['thanks_counters_view'] : false,
		            'POSTER_RECEIVE_COUNT'		=> $poster_receive_count,
				    'POSTER_RECEIVE_COUNT_LINK'	=> append_sid("{$this->phpbb_root_path}thankslist.$this->php_ext", "mode=givens&amp;author_id={$poster_id}&amp;give=false"),
  		            'POSTER_GIVE_COUNT'		=> $poster_give_count,
				    'POSTER_GIVE_COUNT_LINK'	=> append_sid("{$this->phpbb_root_path}thankslist.$this->php_ext", "mode=givens&amp;author_id={$poster_id}&amp;give=true"),
  		            'THANKS_NUMBER'		=> $thanks_number,
                   // 'THANK_IMG'	            => $action == 'thanks' ? str_replace ('..', '.', $user->img('removethanks', $user->lang['REMOVE_THANKS']. $poster_name)) : str_replace('..', '.', $user->img('thankposts', $user->lang['THANK_POST']. $poster_name)),	
  		            'THANK_IMG'		=> $thank_img,
  		            'THANK_PATH'		=> $path,
		        );

 /*           
            $this->add_return(array(
                    'SUCCESS'	    => $message,	
                    'POST_REPUT'	    => $post_reput,	
                    'POST_ID'	            => $post_id,	
			        'THANKS_POSTLIST_VIEW'		=> isset($config['thanks_postlist_view']) ? $config['thanks_postlist_view'] : false,
  			        'S_THANKS_REPUT_GRAPHIC' 	=> isset($config['thanks_reput_graphic']) ? $config['thanks_reput_graphic'] : false,
		            'THANKS_REPUT_HEIGHT'		=> isset($config['thanks_reput_height']) ? sprintf('%dpx', $config['thanks_reput_height']) : false,
		            'THANKS_REPUT_GRAPHIC_WIDTH'=> isset($config['thanks_reput_level']) ? (isset($config['thanks_reput_height']) ? sprintf('%dpx', $config['thanks_reput_level']*$config['thanks_reput_height']) : false) : false,
		            'THANKS_REPUT_IMAGE' 		=> isset($config['thanks_reput_image']) ? $phpbb_root_path . $config['thanks_reput_image'] : '',
		            'THANKS_REPUT_IMAGE_BACK'	=> isset($config['thanks_reput_image_back']) ? $phpbb_root_path . $config['thanks_reput_image_back'] : '',	
			        'S_MOD_THANKS'				=> $auth->acl_get('m_thanks') ? true :false,
    			    'U_CLEAR_LIST_THANKS_POST'	=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . $this->forum_id . '&amp;p=' . $post_id . '&amp;list_thanks=post'),
 		            'DELETE_IMG' 					=> str_replace('..', '.',  $user->img('icon_post_delete', $user->lang['CLEAR_LIST_THANKS'])),
 			        'THANK_TEXT'				=> $user->lang['THANK_TEXT_1'],
			        'THANK_TEXT_2'				=> ($thanks_number != 1) ? sprintf($user->lang['THANK_TEXT_2PL'], $thanks_number) : $user->lang['THANK_TEXT_2'],
 		            'POST_AUTHOR'		            => $poster_name,
 		            'POST_AUTHOR_FULL'		=> $poster_name,
			        'THANK_ALT'		        => $action == 'add' ? $user->lang['REMOVE_THANKS'] : $user->lang['THANK_POST'],
  			        'THANKS_IMG'	        => $action == 'add' ? 'removethanks-icon' : 'thanks-icon',
 			        'S_POST_ANONYMOUS'			=> ($poster_id == ANONYMOUS) ? true : false,
				)); 
*/
    }
    
    private function clear_list_thanks($poster_id, $forum_id, $topic_id, $post_id)
    {
		$this->user->add_lang_ext('gfksx/thanks_for_posts', 'thanks_mod');
        $sql = "DELETE FROM " . THANKS_TABLE . '
		WHERE post_id  = ' . (int)$post_id;				
	    $result = $this->db->sql_query($sql);		
        
        if ($result == 0)
        {
            $this->error =$user->lang['INCORRECT_THANKS'];	
            return;
       }
        $this->clear_thankers_by_post($post_id);
      
      // get some output parameters
       $sql = "SELECT poster_id, u.username" .
                    " , (select count(poster_id)  from " . THANKS_TABLE . " t where p.poster_id= t.poster_id ) as rcv " .
                    " , (select count(user_id) as give  from  " . THANKS_TABLE . "  t where user_id= " . $this->user->data['user_id'] . " ) as give " .
                    "  FROM  " . POSTS_TABLE .  " p JOIN " . USERS_TABLE . " u on p.poster_id = u.user_id " .
                    "  WHERE post_id=" . $post_id;
        $result = $this->db->sql_query($sql);
        $row = $this->db->sql_fetchrow($result);
        $poster_id = $row['poster_id'];                    
        $poster_name = $row['username'];                    
        $poster_give_count = $row['give'];                    
        $poster_receive_count = $row['rcv'];                    
        $this->db->sql_freeresult($result);
       
            $message = $this->user->lang['CLEAR_LIST_THANKS_POST'];
		        
            $this->return = array(                
                'SUCCESS'	    => $message,	
                    'POST_ID'	            => $post_id,	
                    'POSTER_ID'	            => $poster_id,	
                    'USER_ID'	            => $this->user->data['user_id'],	
                    'THANK_ALT'		=> $this->user->lang['THANK_POST'] . $poster_name,
  		            'THANK_PATH'		=> './app.php/thanks_for_posts/thanks/' . $poster_id . '/' . $forum_id . '/' . $topic_id . '/' . $post_id,
 			        'S_POST_ANONYMOUS'			=> ($poster_id == ANONYMOUS) ? true : false,
		            'POSTER_RECEIVE_COUNT'		=> $poster_receive_count,
				    'POSTER_RECEIVE_COUNT_LINK'	=> append_sid("{$this->phpbb_root_path}thankslist.$this->php_ext", "mode=givens&amp;author_id={$poster_id}&amp;give=false"),
  		            'POSTER_GIVE_COUNT'		=> $poster_give_count,
				    'POSTER_GIVE_COUNT_LINK'	=> append_sid("{$this->phpbb_root_path}thankslist.$this->php_ext", "mode=givens&amp;author_id={$poster_id}&amp;give=true"),
				    'THANKS_COUNTERS_VIEW'		=> isset($this->config['thanks_counters_view']) ? $this->config['thanks_counters_view'] : false,
				);    
    }
 
    private function get_thanks_number($post_id)
    {
		$i = 0;
		foreach($this->thankers as $key => $value)
		{
			if ($this->thankers[$key]['post_id'] == $post_id)
			{
				$i++;
			}
		}
		return $i;
    }   
    
    
    // check if the user has already thanked that post
	private function already_thanked($post_id, $user_id)
	{
		$thanked = false;
        //print_r($this->thankers);
		foreach((array)$this->thankers as $key => $value)
		{
			if ($this->thankers[$key]['post_id'] == $post_id && $this->thankers[$key]['user_id'] == $user_id)
			{
            print_r($this->thankers[$key]);
				$thanked = true;
			}
		}
		return $thanked;
       // print_r('thanked = ' . $thanked);
	}
    private function clear_thankers_by_post($post_id)
    {
		foreach((array)$this->thankers as $key => $value)
		{
			if ($this->thankers[$key]['post_id'] == $post_id )
			{
                unset($this->thankers[$key]);
			}
		}    
    }
    
    	// Output thanks list
	private function get_thanks($post_id)
	{
		//$view = request_var('view', '');
        $view = '';
		$return = '';
		$user_list = array();
		$count = 0;
		$maxcount = (isset($this->config['thanks_number_post']) ? $this->config['thanks_number_post'] : false);
		$further_thanks = 0;
		$further_thanks_text = '';

		foreach($this->thankers as $key => $value)
		{
			if ($this->thankers[$key]['post_id'] == $post_id)
			{
				if ($count >= $maxcount)
				{
					$further_thanks++;
				}
				else
				{
				$user_list[$this->thankers[$key]['username_clean']] = array(
					'thanks_time' => $this->thankers[$key]['thanks_time'],
					'username' => $this->thankers[$key]['username'],
					'user_id' => $this->thankers[$key]['user_id'],
					'user_colour' => $this->thankers[$key]['user_colour'],
					);
				}

				$count++;
			}
		}
		array_multisort($user_list, SORT_DESC);
		$comma = '';
		foreach($user_list as $key => $value)
		{
			$return .= $comma;
			$return .= get_username_string('full', $value['user_id'], $value['username'], $value['user_colour']);
			if (isset($this->config['thanks_time_view']) ? $this->config['thanks_time_view'] : false)
			{
				$return .= ($value['thanks_time']) ? ' ('.$this->user->format_date($value['thanks_time'], false, ($view == 'print') ? true : false) . ')' : '';
			}
			$comma = ' &bull; ';
		}

	   if ($further_thanks > 0)
	   {
		  $further_thanks_text = ($further_thanks == 1) ? $this->user->lang['FURTHER_THANKS'] : sprintf($this->user->lang['FURTHER_THANKS_PL'], $further_thanks);
	   }
	   $return = ($return == '') ? false : ($return . $further_thanks_text);
	   return $return;
	}
    
    private function get_poster_details($poster_id, &$poster_name, &$poster_name_full )
    {
        $sql = 'SELECT username, user_colour FROM ' . USERS_TABLE . 
                    ' WHERE user_id = ' . $poster_id;
        $result = $this->db->sql_query($sql);
        $row = $this->db->sql_fetchrow($result);
        $this->db->sql_freeresult($result);
        if (row)
        {
            $poster_name = $row['username'];
            $poster_name_full = get_username_string('full', $poster_id, $row['username'], $row['user_colour']) ;
        }
    }
    	private function get_key_by_post($post_id, $user_id)
	{
		$i = 0;
		foreach((array)$this->thankers as $key => $value)
		{
			if ($this->thankers[$key]['post_id'] == $post_id && $this->thankers[$key]['user_id'] == $user_id)
			{
				return $i;
			}
            $i++;
		}
		return $thanked;
	}


    
}
