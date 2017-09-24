<?php
// Here is the MySql Query to be run during install
 $sql = array();
 $sql[] = "DROP DATABASE dbpro;";
 $sql[] = "CREATE DATABASE IF NOT EXISTS ".$_db->database.";";
 $sql[] = "USE ".$_db->database.";";
 $sql[] = "CREATE TABLE cmuser (
			UserID VARCHAR(10) NOT NULL,
			Fname VARCHAR(50) NOT NULL,
			Lname VARCHAR(20) NOT NULL,
			profile_pic VARCHAR(200) DEFAULT NULL ,
			about VARCHAR(255) DEFAULT NULL ,
			Email VARCHAR(40) NOT NULL UNIQUE,
			Pass VARCHAR(40) NOT NULL,
			Gender VARCHAR(2) NOT NULL, 
			Country VARCHAR(4) NOT NULL, 
			Phone VARCHAR(16) NOT NULL, 
			email_verif TINYINT DEFAULT 0 ,
			phone_verif TINYINT DEFAULT 0 ,
			DateOfBirth DATE NOT NULL, 
			Date_Of_Reg DATETIME NOT NULL, 
			 CONSTRAINT user_id PRIMARY KEY(UserID)
		 ) ENGINE = InnoDB;";
		 
 $sql[] = "CREATE TABLE UserAccessControl ( 
			UId VARCHAR(10) NOT NULL,
			Log_Attempt INT DEFAULT 0,
			Access_Allowed VARCHAR(8) DEFAULT 'Allowed' ,
			Video_Upload VARCHAR(8) DEFAULT 'Allowed' ,
			 CONSTRAINT UId FOREIGN KEY(UId) REFERENCES cmuser(UserId)
		  ) ENGINE = InnoDB;";

 $sql[] = "CREATE TABLE channel (
			channel_id VARCHAR(10) NOT NULL ,
			channel_author VARCHAR(12) NOT NULL ,
			channel_name VARCHAR(120) NOT NULL ,
			channel_logo VARCHAR(200) DEFAULT NULL ,
			channel_art VARCHAR(200) DEFAULT NULL ,
			discription VARCHAR(2000) DEFAULT NULL ,
			channel_label VARCHAR(200) DEFAULT NULL ,
			channel_tags VARCHAR(200) DEFAULT NULL ,
			creation_date DATETIME NOT NULL ,
			channel_cat VARCHAR(30) NOT NULL ,
			active TINYINT DEFAULT 1 ,
			 CONSTRAINT c_id_pk PRIMARY KEY(channel_id) ,
			 CONSTRAINT c_author_fk FOREIGN KEY(channel_author) REFERENCES cmuser(UserID)
		) ENGINE = InnoDB;";
		
 $sql[] = "CREATE TABLE subscribers (
			channel_id VARCHAR(10) NOT NULL ,
			user_id VARCHAR(10) NOT NULL ,
			sub_date DATETIME NOT NULL ,
			active_by_ch TINYINT DEFAULT 1 ,
			 CONSTRAINT sub_ch_id FOREIGN KEY(channel_id) REFERENCES channel(channel_id),
			 CONSTRAINT sub_u_id FOREIGN KEY(user_id) REFERENCES cmuser(UserID)
		) ENGINE = InnoDB;";

 $sql[] = "CREATE TABLE channel_video (
			video_id VARCHAR(12) NOT NULL ,
			channel_id VARCHAR(10) NOT NULL ,
			file_hash VARCHAR(36) NOT NULL,
			file_loc VARCHAR(255) NOT NULL,
			file_fmt VARCHAR(20) NOT NULL, 
			file_size FLOAT DEFAULT -1 ,
			duration_micSec INT DEFAULT -1 , 
			 CONSTRAINT vid_id PRIMARY KEY(video_id),
			 CONSTRAINT pub_ch_id FOREIGN KEY(channel_id) REFERENCES channel(channel_id)
		 );";

 $sql[] = "CREATE TABLE video (
			video_id VARCHAR(12) NOT NULL ,
			title VARCHAR(120) NOT NULL ,
			discription VARCHAR(2000) DEFAULT NULL ,
			tags VARCHAR(200) DEFAULT NULL ,
			view_count INT DEFAULT 0 ,
			like_count INT DEFAULT 0 ,
			dislike_count INT DEFAULT 0 ,
			duration TIME DEFAULT '00:00:00' ,
			upload_date DATETIME NOT NULL ,
			category VARCHAR(30) DEFAULT NULL ,
			active TINYINT DEFAULT 1 ,
			privacy VARCHAR(10) DEFAULT 'Public',
			 CONSTRAINT vid_fk FOREIGN KEY(video_id) REFERENCES channel_video(video_id)
		) ENGINE = InnoDB;";

 $sql[] = "CREATE TABLE encode_queue ( 
			v_id VARCHAR(12) NOT NULL, 
			v_status VARCHAR(20) DEFAULT 'proc', 
			encode_log VARCHAR(255) DEFAULT 'Waiting' , 
			res_144p VARCHAR(255) DEFAULT NULL, 
			res_240p VARCHAR(255) DEFAULT NULL, 
			res_360p VARCHAR(255) DEFAULT NULL, 
			res_480p VARCHAR(255) DEFAULT NULL, 
			res_540p VARCHAR(255) DEFAULT NULL, 
			res_720p VARCHAR(255) DEFAULT NULL, 
			res_1080p VARCHAR(255) DEFAULT NULL, 
			res_1440p VARCHAR(255) DEFAULT NULL, 
			res_2160p VARCHAR(255) DEFAULT NULL, 
			 CONSTRAINT vid_enc_fk FOREIGN KEY(v_id) REFERENCES channel_video(video_id)
		);";

 $sql[] = "CREATE TABLE accept_formats (
			f_id INT NOT NULL AUTO_INCREMENT ,
			mime_type VARCHAR(30) NOT NULL , 
			extention VARCHAR(10) NOT NULL ,
			 CONSTRAINT accept_pk PRIMARY KEY (f_id) ,
			 CONSTRAINT accept_uq UNIQUE(extention) 
		  ) ENGINE = InnoDB;";

 $sql[] = "CREATE TABLE records ( 
			 name VARCHAR(100) NOT NULL , 
			 val VARCHAR(255) NOT NULL , 
			 val1 VARCHAR(255) DEFAULT NULL , 
			 val2 VARCHAR(255) DEFAULT NULL , 
			  CONSTRAINT sett_pk PRIMARY KEY (name) 
		   ) ENGINE = InnoDB;";
		   
		   
// Google api key = AIzaSyD4einllsbfg_A-7GUjI0MgEEe24ge1ytE
?>
			
