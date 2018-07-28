create procedure extra_query(in ids int)
BEGIN
select categories.id, categories.name, cities.id ctid, (select count(ads.id) from ads where ads.category_id=categories.id and ads.city_id=cities.id) total
            from categories, ads, cities
            where categories.id = ads.category_id and
            ads.city_id = cities.id and
            cities.id=ids AND
            ads.status = 1
            group by categories.id
           ; 
END


CREATE PROCEDURE extra_new_used(in type int, in ids int)
BEGIN
select categories.id, categories.name, cities.id ctid, (select count(ads.id) from ads where ads.category_id=categories.id and ads.city_id=cities.id and ads.item_type=type) total
            from categories, ads, cities
            where categories.id = ads.category_id and
            ads.city_id = cities.id and            
            cities.id=ids and 
            ads.status = 1
            group by categories.id
           ; 
END




CREATE PROCEDURE extra_free(in type int, in ids int)
BEGIN
select categories.id, categories.name, cities.id ctid, (select count(ads.id) from ads where ads.category_id=categories.id and ads.city_id=cities.id and ads.ads_type=type) total
            from categories, ads, cities
            where categories.id = ads.category_id and
            ads.city_id = cities.id and            
            cities.id=ids and 
            ads.status = 1
            group by categories.id
           ; 
END




create procedure home(in cntid int, in stid int)
BEGIN
SELECT categories.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.category_id=categories.id and
         states.id=stid and 
         ads.status=1
   ) as total 
FROM categories ORDER by name asc;

SELECT c.*, 
   (select count(ads.id) 
      from ads, cities, states
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.id=stid and 
         ads.status=1 and 
         cities.id = c.id
   ) as total 
FROM cities as c ORDER by name asc;

SELECT s.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and          
         countries.id=cntid and 
         ads.status=1 and
         states.id = s.id
   ) as total 
FROM states as s ORDER by name asc;

SELECT c.*, 
      (select count(ads.id) 
      from ads, cities, states, countries 
      where ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.status=1 and
         countries.id=c.id
         ) as total 
FROM countries c where id=cntid 
ORDER by name asc;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and  
ads.item_type=2 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and  
ads.item_type=1 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.ads_type=2 and 
ads.status=1;
END


####################################################

create procedure city(in cntid int, in stid int, in ctid int)
BEGIN
SELECT categories.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.category_id=categories.id and
         cities.id=ctid and 
         ads.status=1
   ) as total 
FROM categories ORDER by name asc;

SELECT c.*, 
   (select count(ads.id) 
      from ads, cities, states
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.id=stid and 
         ads.status=1 and 
         cities.id = c.id
   ) as total 
FROM cities as c ORDER by name asc;

SELECT s.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and          
         countries.id=cntid and 
         ads.status=1 and
         states.id = s.id
   ) as total 
FROM states as s ORDER by name asc;

SELECT c.*, 
      (select count(ads.id) 
      from ads, cities, states, countries 
      where ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.status=1 and
         countries.id=c.id
         ) as total 
FROM countries c where id=cntid 
ORDER by name asc;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and  
ads.item_type=2 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and 
ads.item_type=1 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and 
ads.ads_type=2 and 
ads.status=1;
END


###################################################################################
####################################################

create procedure new_used_state(in cntid int, in stid int, in type int)
BEGIN
SELECT categories.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.category_id=categories.id and
         states.id=stid and 
         ads.item_type=type and
         ads.status=1
   ) as total 
FROM categories ORDER by name asc;

SELECT c.*, 
   (select count(ads.id) 
      from ads, cities, states
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.id=stid and 
         ads.status=1 and
         ads.item_type=type and
         cities.id = c.id
   ) as total 
FROM cities as c ORDER by name asc;

SELECT s.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and          
         countries.id=cntid and 
         ads.status=1 and
         ads.item_type=type and
         states.id = s.id
   ) as total 
FROM states as s ORDER by name asc;

SELECT c.*, 
      (select count(ads.id) 
      from ads, cities, states, countries 
      where ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.status=1 and
         ads.item_type=type and
         countries.id=c.id
         ) as total 
FROM countries c where id=cntid 
ORDER by name asc;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and  
ads.item_type=2 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.item_type=1 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.ads_type=2 and 
ads.status=1;
END



#####################################################################
create procedure new_used_city(in cntid int, in stid int, in ctid int, in type int)
BEGIN
SELECT categories.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.category_id=categories.id and
         cities.id=ctid and 
         ads.item_type=type and
         ads.status=1
   ) as total 
FROM categories ORDER by name asc;

SELECT c.*, 
   (select count(ads.id) 
      from ads, cities, states
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.id=stid and
         ads.status=1 and
         ads.item_type=type and
         cities.id = c.id
   ) as total 
FROM cities as c ORDER by name asc;

SELECT s.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and          
         countries.id=cntid and 
         ads.status=1 and
         ads.item_type=type and
         states.id = s.id
   ) as total 
FROM states as s ORDER by name asc;

SELECT c.*, 
      (select count(ads.id) 
      from ads, cities, states, countries 
      where ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.status=1 and
         ads.item_type=type and
         countries.id=c.id
         ) as total 
FROM countries c where id=cntid 
ORDER by name asc;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and  
ads.item_type=2 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and
ads.item_type=1 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and
ads.ads_type=2 and 
ads.status=1;
END









create procedure home_state(in ids int, in scid int)
BEGIN
SELECT categories.*, (select count(ads.id) from ads, cities, states, countries where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id and ads.category_id=categories.id and countries.id=ids and ads.status=1) as total FROM categories ORDER by name asc;

SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1) as total FROM cities, states, countries where cities.state_id=states.id AND states.country_id=countries.id and countries.id=ids ORDER by cities.name asc;

SELECT states.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND cities.state_id=states.id and ads.status=1) as total FROM states where states.country_id=ids ORDER by name asc;

SELECT countries.*, (select count(ads.id) from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id    and ads.status=1) as total FROM countries where id=ids ORDER by name asc;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.id = scid and ads.item_type=2 and ads.status=1;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.id = scid and ads.item_type=1 and ads.status=1;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.id = scid and ads.ads_type=2 and ads.status=1;
END



create procedure home_city(in ids int, in scid int)
BEGIN
SELECT categories.*, (select count(ads.id) from ads, cities, states, countries where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id and ads.category_id=categories.id and countries.id=ids and ads.status=1) as total FROM categories ORDER by name asc;

SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1) as total FROM cities, states, countries where cities.state_id=states.id AND states.country_id=countries.id and countries.id=ids ORDER by cities.name asc;

SELECT states.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND cities.state_id=states.id and ads.status=1) as total FROM states where states.country_id=ids ORDER by name asc;

SELECT countries.*, (select count(ads.id) from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id    and ads.status=1) as total FROM countries where id=ids ORDER by name asc;

select count(ads.id) total from ads, cities where ads.city_id = cities.id AND cities.id = scid and ads.item_type=2 and ads.status=1;

select count(ads.id) total from ads, cities where ads.city_id = cities.id AND cities.id = scid and ads.item_type=1 and ads.status=1;

select count(ads.id) total from ads, cities where ads.city_id = cities.id AND cities.id = scid and ads.ads_type=2 and ads.status=1;
END







create procedure category(in ids int)
BEGIN
SELECT categories.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND ads.category_id=categories.id and cities.id=ids and ads.status=1) as total FROM categories ORDER by categories.name asc;
END






create procedure city(in ids int)
BEGIN
SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id    and ads.status=1) as total FROM cities, states where cities.state_id=states.id AND  states.id=ids ORDER by cities.name asc;
END





create procedure state(in ids int)
BEGIN
SELECT states.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND cities.state_id=states.id    and ads.status=1) as total FROM states where states.country_id=ids ORDER by name asc;
END




CREATE PROCEDURE category_country(in ids int, in cntid int)
BEGIN
SELECT cities.*, (select count(ads.id) from ads, cities as c, states where ads.city_id = c.id AND c.state_id = states.id and ads.category_id=ids and ads.status=1 and c.id=cities.id AND states.country_id=cntid) as total FROM cities ORDER by cities.name asc; 
END


CREATE PROCEDURE new_used_city(in type int, in cid int) 
BEGIN 
SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1 AND ads.item_type=type) as total FROM cities, states where cities.state_id=states.id AND states.country_id=cid ORDER by cities.name asc; 
END 


CREATE PROCEDURE free_item(in cid int) 
BEGIN 
SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1 AND ads.ads_type=2) as total FROM cities, states where cities.state_id=states.id AND states.country_id=cid ORDER by cities.name asc; 
END 


CREATE PROCEDURE login()
BEGIN
UPDATE ads set status=3 
WHERE DATEDIFF(CURDATE(), DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(posted)), '%Y-%m-%d')) >= 45 AND first_ad=1;
END