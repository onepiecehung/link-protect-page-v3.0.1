<?php
/* >_ Developed by Vy Nghia */
class Database
{
	protected $dbhost;
	protected $dbuser;
	protected $dbpass;
	protected $dbname;
	
	public function dbhost($dbhost){
		$this->dbhost = $dbhost;
	}
	
	public function dbuser($dbuser){
		$this->dbuser = $dbuser;
	}
	
	public function dbpass($dbpass){
		$this->dbpass = $dbpass;
	}
	
	public function dbname($dbname){
		$this->dbname = $dbname;
	}
	
	public function connect(){
		$con = @mysql_connect($this->dbhost, $this->dbuser, $this->dbpass);
		@mysql_select_db($this->dbname, $con);
	}
	
	public function dbinfo($db){
		echo $this->$db;
	}
}

class Protect
{
	public $id;
	public function setCreatorID($userID){
		$this->id = $userID;
	}
	public function getUserInfo($accessToken){
		global $userID, $userName, $CreatorID, $CreatorName;
		$UserApi = 'https://graph.facebook.com/me?access_token='.$accessToken;
		$user = json_decode(file_get_contents($UserApi, true));
		$userID = $user->id;
		$userName = $user->name;
				
		if($this->id !== null){
		$CreatorApi = 'https://graph.facebook.com/'.$this->id.'?access_token='.$accessToken;
		$crt = json_decode(file_get_contents($CreatorApi, true));
		$CreatorID = $crt->id;
		$CreatorName = $crt->name;
		}
	}
	
	public function fetchHash($Hash){
		global $URL;
		$Select = mysql_query("SELECT * FROM `link` WHERE `Hash` = '$Hash'");
		$URL = mysql_fetch_array($Select);
	}

	public function Check($TargetID, $accessToken, $Hashtag, $PostID, $TagsRequire, $userID){
		global $FoundPost, $FoundPostID, $FoundPostURL, $Liked, $tagsCount;
		
		$FeedApi = 'https://graph.facebook.com/'.$TargetID.'/feed?limit=100&access_token='.$accessToken;
		$FeedJson = json_decode(file_get_contents($FeedApi), true);
		
		
		if(is_array($FeedJson) or is_object($FeedJson)){
			foreach($FeedJson['data'] as &$feed) {
				if(strpos(@$feed['message'], $Hashtag) !== FALSE) {
					$FoundPost = true;
					$FoundPostID = str_replace($TargetID.'_', '',$feed['id']);
					
					$PostApi = 'https://graph.facebook.com/v2.10/'.$TargetID.'_'.$FoundPostID.'?fields=id,permalink_url,message&access_token='.$accessToken;
					$PostPage = json_decode(file_get_contents($PostApi));
					
					$FoundPostURL = $PostPage->permalink_url;

					$LikeApi = 'https://graph.facebook.com/v2.10/'.$TargetID.'_'.$FoundPostID.'/reactions?fields=id&pretty=0&live_filter=no_filter&limit=5000&access_token='.$accessToken;
					$FindLike = json_decode(file_get_contents($LikeApi));
					foreach($FindLike->data as $like){
					if($like->id == $userID){
						$Liked = true;
						}
					}
				}
			}
		}
		
		if($TagsRequire == 1){
			$tagsCount = 3;
			$CommentsApi = 'https://graph.facebook.com/'.$TargetID.'_'.$FoundPostID.'/comments?limit=3000&fields=id,from,message,message_tags&access_token='.$accessToken;
			$CommentsJson = json_decode(file_get_contents($CommentsApi));
			
			if(is_array($CommentsJson) or is_object($CommentsJson)){
				foreach($CommentsJson->data as &$cmt) {
					if($cmt->from->id == $userID){
						foreach($cmt->message_tags as $tags){
							$tagsCount--;
						}
					}
				}
			}
		}
	}
}

class CreateLink
{
	public $GoogleApiKey;
	
	public function setGoogleApiKey($Key){
		$this->GoogleApiKey = $Key;
	}
	
	public function getShortenedLink($Link){
		$longUrl = $Link;
		$apiKey  = $this->GoogleApiKey;

		$postData = array('longUrl' => $longUrl);
		$jsonData = json_encode($postData);

		$curlObj = curl_init();

		curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObj, CURLOPT_HEADER, 0);
		curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curlObj, CURLOPT_POST, 1);
		curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

		$reply = curl_exec($curlObj);

		$json = json_decode($reply);

		curl_close($curlObj);

		if(isset($json->error)){
			return $json->error->message;
		} else{
			return $json->id;
		}
	}
	
	public function insertLink($fbid, $hash, $password, $link, $shortlink, $tagsrequire, $time){
		mysql_query("INSERT INTO `link`(`id`, `FBID`, `PostID`, `Hash`, `Password`, `Url`, `SUrl`, `tags_require`, `Time`) VALUES ('', '$fbid', '', '$hash', '$password', '$link', '$shortlink', '$tagsrequire','$time')");	
	}
	
	public function deleteLink($id){
		mysql_query("DELETE FROM `link` WHERE `id` = '$id'");
	}
}

class Admin
{
	public function getAdminInfo($session){
		global $admins;
		$checksession = mysql_query("SELECT * FROM `manager` WHERE `username` = '$session'");
		$admins = mysql_fetch_array($checksession);
	}
	
	public function Update($user, $pass, $name){;
		mysql_query("UPDATE `manager` SET `username`='{$user}',`password`='{$pass}',`name`='{$name}' WHERE 1");
	}
}