
Database Name: MoneyMile
Table Prefix: mm_

Table: mm_users
PK	id				int(20) 		Not Null	UNSIGNED 	AUTO_INCREMENT
FK	role_id			int(10)			Not Null	UNSIGNED	INDEX
	name			varchar(60)								INDEX
	email			varchar(100) 	Not Null 	Unique		INDEX
	mobile			varchar(10) 	Null
	avatar			varchar(255) 	Null
	verified		boolean			Not Null 	Default false/0
	password		varchar(255) 	Not Null 	Bycrypt
	remember_token	varchar(100) 	Null 
	created_at		timestamp
	updated_at		timestamp

Note: login_id, login_with, age, intestedin, social_links etc will be added as custom fields in mm_usersmeta table. Hence, this table provide a flexiblity to add more custom fields in future without changing the table.

Table: mm_user_metas
PK	id			int(20)			Not Null	UNSIGNED	AUTO_INCREMENT
FK	user_id		int(20)			Not Null	UNSIGNED	INDEX
	meta_key	varchar(255)	Not Null				INDEX
	meta_value	longtext		Null


Table: mm_verify_users
FK	user_id 		int(10)			UNSIGNED
	token 			varchar(255)	Not Null Unique 	INDEX
	created_at		timestamp
	updated_at		timestamp


Table: mm_password_resets
FK	email 			varchar(255)	INDEX
	token 			varchar(255)	INDEX
	created_at		timestamp
	updated_at		timestamp


Table: mm_permissions ( Master Table )
PK	id 					int(10)			UNSIGNED 	AUTO_INCREMENT
	key					varchar(100)	Not Null
	route				varchar(50)		Not Null
	created_at			timestamp
	updated_at			timestamp


Table: mm_roles ( Master Table )
PK	id 				int(10)			UNSIGNED 	AUTO_INCREMENT
	name 			varchar(50)		Not Null	Unique INDEX
	table_name		varchar(50) 	Not Null	
	created_at		timestamp
	updated_at		timestamp


Table: mm_permission_roles
PK	permission_id 	int(10)	UNSIGNED	INDEX
FK	role_id 		int(10)	UNSIGNED	INDEX


Table: mm_age	( Master Table )
PK	id 				int(10)			UNSIGNED 	AUTO_INCREMENT
	value 			varchar(20)		Not Null	Unique Index
	created_at		timestamp
	updated_at		timestamp


Table: mm_interestedin ( Master Table )
PK	id 				int(10)			UNSIGNED 	AUTO_INCREMENT
	tags 			varchar(100)	Not Null	Unique Index
	created_at		timestamp
	updated_at		timestampb


Table: mm_wishlists
PK	id 				int(10)			UNSIGNED 	AUTO_INCREMENT
FK	user_id			int(10)			UNSIGNED	Not Null	INDEX
API	video_id		int(10)			UNSIGNED	Not Null	INDEX
	created_at		timestamp
	updated_at		timestamp


Table: mm_comments
PK	id 				int(10)			UNSIGNED 	AUTO_INCREMENT
FK	user_id			int(10)			UNSIGNED 	INDEX
API	video_id		int(10)			UNSIGNED 	INDEX
	parent_id		int(10)			UNSIGNED	Default 0 (root)
	comments 		varchar(255)	Not Null
	created_at		timestamp
	updated_at		timestamp


Table: mm_translations ( Master Table )
PK	id 				int(10)			UNSIGNED 	AUTO_INCREMENT
	name 			varchar(100)	Not Null	Unique Index
	code 			varchar(5)		Not Null	 
	locale 			varchar(10)		Not Null	Unique Index
	image			varchar(50)		Not Null	
	order			int(3)			Not Null  	Default 0
	status			tinyint(1)		Not Null	None
	created_at		timestamp
	updated_at		timestamp


Table: mm_informations
PK	id 					int(10)			UNSIGNED 	AUTO_INCREMENT	
FK	language_id			int(10)			UNSIGNED	
	title 				varchar(255)	Not Null
	route				Varchar(50)		Not Null
	short_description	varchar(255)	Null
	description 		longtext		Null
	meta_title			varchar(255)	Null
	meta_description	varchar(255)
	meta_keyword		varchar(255)


Table: mm_settings
PK	id 					int(10)			UNSIGNED 	AUTO_INCREMENT
	key					varchar(255)	Not Null	Unique		INDEX
	display_name		varchar(255)	Not Null
	value 				text 			Null
	type				varchar(20)		Not Null
	order 				int(5)			Not Null 	Default 	1


Table: mm_speakers
PK	id 					int(10)			UNSIGNED 	AUTO_INCREMENT
FK	video_id			int(10)			UNSIGNED
	name 				varchar(100)	Not Null	Unique		INDEX
	route 				varchar(100)	Not Null	Unique		INDEX
	designation			varchar(50)		Null
	short_description	varchar(100)	Null
	bio					text 			Null
	avatar				varchar(100)	Null
	created_at			timestamp
	updated_at			timestamp


Table: mm_speaker_metas
PK	id 					int(10)			UNSIGNED 	AUTO_INCREMENT
FK	speaker_id			int(10)			UNSIGNED
	meta_key			varchar(255)	Not Null	Unique		INDEX
	meta_value			longtext		Null


Table: mm_menus
PK	id 					int(10)			UNSIGNED 	AUTO_INCREMENT
	name				varchar(255)	Not Null
	created_at			timestamp
	updated_at			timestamp


Table: mm_menu_items
PK	id 					int(10)			UNSIGNED 	AUTO_INCREMENT
FK	menu_id				int(10)			UNSIGNED	INDEX
	title				varchar(255)	Not Null
	route				varchar(50)		Not Null	INDEX
	url 				varchar(50)		Not Null
	target				varchar(50)		Not Null	Default _self
	icon_class			varchar(50)		Null
	parent_id			int(11)			Null		Default 0
	order				int(11)			Null		Default	0
	created_at			timestamp
	updated_at			timestamp


Video Will be featched by BrightCove API, Hence not table regarding viedeo is mentioned here.