-- Relief Centers for Vijayawada, Machilipatnam, and Guntur
-- Run this in phpMyAdmin SQL tab after selecting disaster_relief database

USE `disaster_relief`;

-- Vijayawada Centers
INSERT INTO `centers` (`name`,`type`,`latitude`,`longitude`,`address`,`phone`,`opening_hours`,`supplies`) VALUES
('Vijayawada Municipal Corporation Relief Center','shelter',16.5062,80.6480,'MG Road, Vijayawada','0866-2574488','24/7','Blankets, beds, food, water'),
('Indira Gandhi Municipal Stadium Shelter','shelter',16.5100,80.6320,'Mahatma Gandhi Road, Vijayawada','0866-2429999','24/7','Emergency shelter, medical aid'),
('Government General Hospital','medical',16.5080,80.6210,'Hospital Road, Vijayawada','0866-2578911','24/7','Emergency medical care, medicines, ambulance'),
('Anna Canteen - Benz Circle','food',16.5065,80.6380,'Benz Circle, Vijayawada','0866-2434343','08:00-20:00','Free meals, drinking water'),
('Red Cross Society Vijayawada','medical',16.5150,80.6450,'Eluru Road, Vijayawada','0866-2471555','09:00-18:00','First aid, blood bank, medical supplies'),
('Krishna River Water Supply Point','water',16.5200,80.6100,'Prakasam Barrage, Vijayawada','0866-2424242','24/7','Drinking water, water purification');

-- Machilipatnam Centers
INSERT INTO `centers` (`name`,`type`,`latitude`,`longitude`,`address`,`phone`,`opening_hours`,`supplies`) VALUES
('Machilipatnam Municipal Relief Camp','shelter',16.1875,81.1389,'Collectorate Road, Machilipatnam','08672-222333','24/7','Shelter, food, blankets'),
('District Government Hospital','medical',16.1850,81.1350,'Hospital Road, Machilipatnam','08672-222456','24/7','Emergency care, medicines'),
('Coastal Relief Food Center','food',16.1900,81.1400,'Beach Road, Machilipatnam','08672-223344','07:00-21:00','Meals, packaged food, water'),
('Machilipatnam Port Water Station','water',16.1820,81.1450,'Port Area, Machilipatnam','08672-224455','24/7','Clean drinking water');

-- Guntur Centers
INSERT INTO `centers` (`name`,`type`,`latitude`,`longitude`,`address`,`phone`,`opening_hours`,`supplies`) VALUES
('Guntur Municipal Corporation Shelter','shelter',16.3067,80.4365,'Arundelpet, Guntur','0863-2323232','24/7','Emergency shelter, food, water'),
('Government General Hospital Guntur','medical',16.3100,80.4400,'Kothapeta, Guntur','0863-2228888','24/7','Medical care, emergency services'),
('Community Kitchen - Brodipet','food',16.3050,80.4320,'Brodipet, Guntur','0863-2345678','08:00-20:00','Free meals, snacks, water'),
('Guntur Medical College Hospital','medical',16.3150,80.4500,'Medical College Road, Guntur','0863-2287777','24/7','Advanced medical care, ICU, ambulance'),
('Municipal Water Supply Center','water',16.3000,80.4300,'Lakshmipuram, Guntur','0863-2234567','24/7','Drinking water distribution');
