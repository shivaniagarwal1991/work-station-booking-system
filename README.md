# Work Station Booking System

This project consist the APIs which will help teams to efficiently book the work stations during this tough time. 

#### What do i bring to the table other than the expacted assignment requirments?
- User can book the workstation only for next five days excluding today & including weekend to offer the efficient & equal utilization of the resources.
- User can only book for future dates or future time if they are doing for the same day.
- We are allowing only one day booking.
- The database table has status as well in case user cancel the appointment and the resource could be available again however we don't have that endpoint yet.
- Booking algorithm has covered all conflicting booking attempts.

#### Steps to run the application

- clone the project
- enter into the root folder of the application
- please run any one of the below command to run the application
	1. php bin/console server:run 
	2. php -S localhost:8001 -t public

#### Step to setup the database
- **Option 1** run the below commands from project root folder to setup a new database
		1. php bin/console doctrine:database:create
		2. php bin/console doctrine:migration:migrate
- **Option 2** Import the PROJECT_ROOT/work_station_booking.sql file to database with some test data. 
	

#### Endpoints
1. To fetch all desks/meeting rooms:
   GET  http://localhost:8001/work/station

2. Add new desks/meeting rooms:
   POST http://localhost:8001/work/station?name=desk3&type=desk&status=1
   
   **Note: We should send the paramters in request body but to make it simple to test i am taking as query params, personally i don't prefer it.**

   **Request Parameters:**
   1. name: desk or meeting room name
   2. type: desk/meeting (only these two are supported, default is meeting, we could make this list dynamic with another table).
   3. status: 1 (1 - active, 0 - deactive)

3. To book the work station:
    POST http://localhost:8001/booking?work_station_id=1&user_hash=test@gmail.com&start_time=10:00&end_time=17:00&date=04-05-2022
    
    **Note: We should send the paramters in request body but to make it simple to test i am taking as query params, personally i don't prefer it.**

    **Request Parameters:**
    1. work_station_id: id of work_station which we added using add endpoint
    2. user_hash: some unique hash which represent user, i prefer hash over id as they are more secure and not so easy to guess.
    3. date: booking start date (Except weekend)
    4. start_time: booking start time (should be > 09:00)
    5. end_time: booking end time (should be < 17:00)


#### What we can improve?

- I didn't get the time to write the test cases but i usually write unit and integration test cases with negative as well as positive use cases along with data validation. In case you feel that i should write them as well then i would be happy to do that.
- The GET /work/station endpoint should support the pagination to return limited number of records rather than all at once, believe me it will save resource and would be faster.
- I agree that there are still lots of opportunity to refector & clean the code along with custom exception handling etc.
- The values should be more backend driven such as offering slots, allowed days, excluding special days, work station type etc.
