-- Relief Centers for Visakhapatnam (Vizag) and Vizianagaram
-- Run this in phpMyAdmin SQL tab after selecting disaster_relief database

USE `disaster_relief`;

-- Visakhapatnam (Vizag) Centers - Real-time Relief Resources
INSERT INTO `centers` (`name`,`type`,`latitude`,`longitude`,`address`,`phone`,`opening_hours`,`supplies`) VALUES
-- Shelter Centers
('Greater Visakhapatnam Municipal Corporation Relief Center','shelter',17.6869,83.2185,'GVMC Building, Asilmetta, Visakhapatnam','0891-2746464','24/7','Emergency shelter, blankets, beds, food, water, clothing'),
('Andhra University Indoor Stadium Shelter','shelter',17.7300,83.3200,'Andhra University, Visakhapatnam','0891-2844444','24/7','Large capacity shelter, medical aid, food distribution'),
('RK Beach Community Shelter','shelter',17.7231,83.3260,'Beach Road, Visakhapatnam','0891-2565656','24/7','Coastal evacuation shelter, emergency supplies'),
('MVP Colony Relief Camp','shelter',17.7500,83.3100,'MVP Colony, Sector 10, Visakhapatnam','0891-2799999','24/7','Family shelter, children care, elderly support'),

-- Medical Centers
('King George Hospital (KGH)','medical',17.7042,83.2977,'KGH Campus, Maharanipeta, Visakhapatnam','0891-2563333','24/7','Emergency care, trauma center, ICU, ambulance services'),
('Government Hospital for Chest and Communicable Diseases','medical',17.7100,83.3050,'Jagadamba Junction, Visakhapatnam','0891-2755555','24/7','Specialized medical care, isolation wards, medicines'),
('GITAM Institute of Medical Sciences','medical',17.7800,83.3780,'GITAM Campus, Rushikonda, Visakhapatnam','0891-2840000','24/7','Advanced medical care, emergency services, surgery'),
('Red Cross Society Visakhapatnam','medical',17.6950,83.2950,'Dwaraka Nagar, Visakhapatnam','0891-2534567','09:00-18:00','First aid, blood bank, medical supplies, ambulance'),
('Apollo Hospital Visakhapatnam','medical',17.7450,83.3200,'Waltair Main Road, Visakhapatnam','0891-2727272','24/7','Multi-specialty care, emergency services, ICU'),

-- Food Distribution Centers
('Anna Canteen - Jagadamba Junction','food',17.7100,83.3080,'Jagadamba Junction, Visakhapatnam','0891-2888888','07:00-21:00','Free meals, breakfast, lunch, dinner, drinking water'),
('Anna Canteen - Gajuwaka','food',17.6800,83.2100,'Gajuwaka, Visakhapatnam','0891-2666666','07:00-21:00','Subsidized meals, snacks, tea, water'),
('Visakha Jilla Samkshema Samithi Food Center','food',17.6900,83.2900,'Siripuram, Visakhapatnam','0891-2545454','08:00-20:00','Community kitchen, packaged food, emergency rations'),
('Akshaya Patra Foundation Vizag','food',17.7200,83.3150,'NAD Junction, Visakhapatnam','0891-2999999','10:00-19:00','Mass meal distribution, food packets, nutrition support'),
('Coastal Relief Food Distribution Point','food',17.7250,83.3280,'Beach Road, Near Submarine Museum, Visakhapatnam','0891-2567890','24/7','Emergency food supplies, dry rations, water'),

-- Water Supply Centers
('GVMC Water Supply - Beach Road','water',17.7240,83.3270,'RK Beach, Visakhapatnam','0891-2777777','24/7','Clean drinking water, water tankers, purification'),
('Visakhapatnam Port Water Station','water',17.6850,83.2850,'Visakhapatnam Port Area','0891-2525252','24/7','Large capacity water supply, emergency distribution'),
('Mudasarlova Reservoir Water Point','water',17.7600,83.3400,'Mudasarlova, Visakhapatnam','0891-2898989','24/7','Drinking water, water purification tablets'),
('Meghadri Gedda Water Supply','water',17.7000,83.2800,'Asilmetta, Visakhapatnam','0891-2676767','24/7','Municipal water supply, emergency water distribution');

-- Vizianagaram Centers - Real-time Relief Resources
INSERT INTO `centers` (`name`,`type`,`latitude`,`longitude`,`address`,`phone`,`opening_hours`,`supplies`) VALUES
-- Shelter Centers
('Vizianagaram Municipal Corporation Relief Center','shelter',18.1124,83.4125,'Municipal Office Road, Vizianagaram','08922-228228','24/7','Emergency shelter, blankets, food, water, medical aid'),
('District Collectorate Relief Camp','shelter',18.1150,83.4100,'Collectorate Complex, Vizianagaram','08922-220220','24/7','Government relief camp, family shelter, supplies'),
('Vizianagaram Fort Community Shelter','shelter',18.1100,83.4150,'Fort Area, Vizianagaram','08922-225225','24/7','Historical building shelter, emergency accommodation'),

-- Medical Centers
('Government General Hospital Vizianagaram','medical',18.1140,83.4110,'Hospital Road, Vizianagaram','08922-222333','24/7','Emergency medical care, surgery, medicines, ambulance'),
('District Hospital Vizianagaram','medical',18.1160,83.4090,'Main Road, Vizianagaram','08922-223344','24/7','General medical care, outpatient services, emergency'),
('Primary Health Center - Cantonment','medical',18.1200,83.4200,'Cantonment Area, Vizianagaram','08922-224455','08:00-20:00','Basic medical care, first aid, medicines'),
('Red Cross Vizianagaram','medical',18.1130,83.4130,'Gandhi Nagar, Vizianagaram','08922-226677','09:00-18:00','First aid, blood donation, medical supplies'),

-- Food Distribution Centers
('Anna Canteen - Vizianagaram','food',18.1135,83.4120,'Bus Stand Road, Vizianagaram','08922-229999','07:00-21:00','Free meals, breakfast, lunch, dinner'),
('Community Kitchen - Collectorate','food',18.1145,83.4105,'Near Collectorate, Vizianagaram','08922-227788','08:00-20:00','Community meals, food packets, drinking water'),
('Tribal Welfare Food Center','food',18.1080,83.4080,'Tribal Welfare Office, Vizianagaram','08922-221122','09:00-18:00','Food distribution, dry rations, nutrition support'),
('Relief Food Distribution Point','food',18.1170,83.4140,'Market Area, Vizianagaram','08922-228899','24/7','Emergency food supplies, packaged meals, water'),

-- Water Supply Centers
('Municipal Water Supply Center','water',18.1120,83.4115,'Water Works, Vizianagaram','08922-223355','24/7','Clean drinking water, water tankers'),
('Vizianagaram Water Treatment Plant','water',18.1190,83.4160,'Reservoir Road, Vizianagaram','08922-224466','24/7','Purified water supply, emergency distribution'),
('District Water Supply Point','water',18.1110,83.4095,'Main Road, Vizianagaram','08922-225577','24/7','Drinking water distribution, water purification');

-- Verify the data
SELECT COUNT(*) as 'Total Centers Added' FROM `centers`;
SELECT type, COUNT(*) as 'Count' FROM `centers` GROUP BY type;
