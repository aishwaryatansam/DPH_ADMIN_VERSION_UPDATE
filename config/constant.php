<?php
return [


	'status' => [
		1 => 'Active',
		0 => 'InActive',
	],

	'yes_or_no' => [
		'no' => 'No',
		'yes' => 'Yes',
	],

	'file_storage_disk' => 'tndphpmfiles',

	"page_length_dropdown" => [
			10 => 10,
			25 => 25,
			50 => 50,
			100 => 100,
	],
	"constant_page_length" => 10,

	'default_page_length' => 25,

	//length to show the column text in list page. this will use in string lenght helpers
	'default_string_length' => 20,

	'gender' => [
		1 => 'Male',
		2 => 'Female',
		3 => 'Others',
	],

	'user_role' => [
		1 => 'Admin-approver',
		2 => 'Admin-verifier',
		3 => 'Admin-user'
	],

	'user_type' => [
		7 => 'Super Admin',
		8 => 'Sub Admin',
		// 3 => 'Employee',
		1 => 'State',
		2 => 'District',
		3 => 'HUD',
		4 => 'Block',
		5 => 'PHC',
		6 => 'HSC'
	],

	'facility_level' => [
		1 => 'State',
		2 => 'District',
		3 => 'HUD',
		4 => 'Block',
		5 => 'PHC',
		6 => 'HSC'
	],

	'social_media_type' => [
		1 => 'Youtube',
		2 => 'Instagram',
		3 => 'Facebook',
		4 => 'Twitter'
	],

	'menu_to_show' => [
		1 => 'Homepage',
		2 => 'Health Advisory',
	],

	'default_user_password' => "tndphpm@123",

	'contact_types' => [
		1 => 'common',
		2 => 'state',
		3 => 'district',
		4 => 'hud',
		5 => 'ivcz',
		6 => 'other_1',
		7 => 'other_2',
		8 => 'block',
		9 => 'phc',
		10 => 'hsc',
	],

	'image_type' => [
		1 => 'entrance_image',
		2 => 'waiting_area_image',
		3 => 'other_image',
		4 => 'general_image',
		5 => 'op_image',
		6 => 'ip_image',
		7 => 'pharmacy_image',
		8 => 'lab_image',
		9 => 'clinic_area_image',
		10 => 'Under Construction Image 1',
		11 => 'Under Construction Image 2',
		12 => 'Under Construction Image 3',
		13 => 'Under Construction Image 4',
		14 => 'Under Construction Image 5',
		15 => 'Under Construction Image 6',
		16 => 'Under Construction Image 7',
		17 => 'Under Construction Image 8',
		18 => 'Under Construction Image 9',
		19 => 'Under Construction Image 10',
		20 => 'toilet_area_image',
	],


	'document_type' => [
		1 => 'land1_document',
		2 => 'land2_document',
		3 => 'land3_document',
	],

	'testimonial_type' => [
		1 => 'Chief Minister',
		2 => 'Minister',
		3 => 'Secretory',
		4 => 'Director',
	],

//facility_profile
	'building_status' => [
        1 => 'Rented',
        2 => 'Own',
        3 => 'Public Buildings / Rent Free',
        4 => 'Work Completed by PWD / Private Concern',
        5 => 'Ready for Inauguration - Date of Inauguration & Whom',
        6 => 'Culvert Status - Yes / No',
        7 => 'Handed Over/Occupied - Date / Month of Occupy',
        8 => 'Compound Wall - Fully or Partial',
        9 => 'Water Tank / Sump / OHT if Yes Capacity',
        10 => 'RO Availability - If yes, Make and Capacity in Liters',
        11 => 'Approach Road',
        12 => 'Generator / UPS availability - If available, Make capacity & Year of installation',
        13 => 'Power LT / HT Availability - KVA & Year of Installation',
        14 => 'Under Construction',
    ],
    'under_construction_status' => [
        1 => 'Land identified',
        2 => 'Basement Level',
        3 => 'Wall level',
        4 => 'Lintel level',
        5 => 'Roof level',
        6 => 'G+1 Work Started',
        7 => 'Support services Water/Electrical/Carpentry',
        8 => 'Painting',
	],

	//Funding details for facility_profile
	'funding_sources' => [
        1 => 'State Fund',
        2 => 'NHM Fund',
        3 => '15 FC Fund',
        4 => 'Tribal Welfare Fund',
        5 => 'SBGF Fund',
    ],

    // Media- gallery
    'media_gallery' => [
        1 => 'Image',
        2 => 'Audio',
        3 => 'Video',
    ],
];
