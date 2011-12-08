Code Monkyes TravelHack Repo!


                      __,__
             .--.  .-"     "-.  .--.
            / .. \/  .-. .-.  \/ .. \
           | |  '|  /   Y   \  |'  | |
           | \   \  \ 0 | 0 /  /   / |
            \ '- ,\.-"`` ``"-./, -' /
             `'-' /_   ^ ^   _\ '-'`
             .--'|  \._ _ _./  |'--.
           /`    \   \.-.  /   /    `\
          /       '._/  |-' _.'       \
         /          ;  /--~'   |       \
        /        .'\|.-\--.     \       \
       /   .'-. /.-.;\  |\|'~'-.|\       \
       \       `-./`|_\_/ `     `\'.      \
        '.      ;     ___)        '.`;    /
          '-.,_ ;     ___)          \/   /
           \   ``'------'\       \   `  /
            '.    \       '.      |   ;/_
          ___>     '.       \_ _ _/   ,  '--.
        .'   '.   .-~~~~~-. /     |--'`~~-.  \
       // / .---'/  .-~~-._/ / / /---..__.'  /
      ((_(_/    /  /      (_(_(_(---.__    .'
                | |     _              `~~`
                | |     \'.
                 \ '....' |
                  '.,___.'


![Main View](http://www.trafiklab.se/sites/default/files/screnshots/mainview.png)
![Map View](http://www.trafiklab.se/sites/default/files/screnshots/mapview.png)
![Ride Confirmation](http://www.trafiklab.se/sites/default/files/screnshots/ridecreated.png)
![Ride Detail](http://www.trafiklab.se/sites/default/files/screnshots/ridedetailview.png)
![Ride Joined](http://www.trafiklab.se/sites/default/files/screnshots/ridejoined.png)
![Ride List](http://www.trafiklab.se/sites/default/files/screnshots/ridelistview.png)

#SHORT DESCRIPTION OF THE SERVICE 
This service (Find me a ride) allows users to search for, create and join rides from wherever in the city (or between cities eventually) to wherever. A ride is a set of point to point journeys (each belonging to one user) which makes a reasonable route; it is a trade-off between stops, passengers, times and fuel consumption. For example, if a passengers goes from Lindholmen to Brunsparken, another one goes from Domkyrkan to Chalmers, and another one goes from Mossen to Linjeplatsen, a possible ride could be from Lindholmen to Linjeplatse, passing by all the requested points. Rides are dispatched by Transportation Service Provides (a.k.a Taxi companies, mini cab companies, public transportation). 

##Value of the service 

For the end user the value of this service consists in finding a cheap ride to share with other people from wherever to wherever. For the Transportation Service Providers the value is the increased flow of customers and better resource (vehicles, fuel) allocation. 


#Background and vision with the service 
At the current moment public transportation suffer form the following problems: 

* Bus stops can be far from destination or departure of passengers 

* Bus stops don’t cover all locations 

* Buses don’t ride at all times

* Bus rides are not efficient: at rush hours, several crowded buses, at not busy hours, several empty buses.

* Several bus stops without any passenger getting on or off: Could take better route if knowing that there is no passenger in some stops (i.e. avoid traffic)

The root cause is that mass transportation is not passenger-aware: only passengers are bus-aware.

 

Our sustainable vision consists of a feature with a better allocation of mass transportation resources, an increased capillarity without an increase in assets (i.e. vehicles, fuel) and a on demand transportation service for customers. Moreover the investment in mass transportation will not only be on the shoulders of the public sector (i.e. state controlled) but will gradually move to the private sector. Finally more private transportation service providers will lead to a higher quality of service resulting in more satisfied customers. 

#Objectives and target group with the service
Please note: FOR PERSONAS ONLY (TRANSPORTATION SERVICE PROVIDES ARE INTENTIONALLY IGNORED)

##For young people (Sofia, Elena, Oscar):

These people are active society members; unplanned transportation is common practice among them and it happens frequently that they cannot meet bus (or train) schedules. The flexible schedule that our system provides can meet the needs of these types of customers. For this category of persons we offer a reliable alternative to public transportation. Moreover this alternative has a highter capillarity (it can bring them from anywhere to anywhere) , it is on demand at any time of the day and night and cheaper than taxi and car.

##For professionals (busy schedule, time critical) (Cintia, Jakob):

Even though these people usually plan their movements, yet public transportation is not convenient for them because the schedule does not meet their need and commuting between destinations and stops it stressful and time consuming. For this category we offer a reduced commuting distance (and time) between stops and destinations, and a hassle free yet affordable mean of getting around. 

##For the elderly:

These people might have special mobility requirements that not all forms of public transportation can meet, or they might be challenged by the crowd typical of mass transportation systems. To this segment of customers our systems provides a on demand, capillar, reliable, crowd free transportation mean that can accommodate their special mobility needs.

##For people whom simply don't like public transportation(Cycilia):

These category of people don't use public transportation since they believe it is not convenient enough for them, and doesn't match with their lifestyles. Even for them, there would be situations when they are obliged to use forms of transportations other that their private cars. For them, this system offers a compromise yet still closer to private transportation.

#Description of the functionality
The service is comprised of two parts: a mobile application and a server backend that provides the data and performs computations.

Using the mobile application it is possible to search,join and create rides to any destination.

##Startup phase:

The user interaction with the systems starts when he/she wants to travel. The user will then start up the mobile application (mainview.png) and will be presented with the possibility to specify a pickup location (defaults to his/hers current location) and a destination.

##Trip definition:

Destination and Departure Locations  can be selected from a map (MapView.png) by tapping on the desired location.

##Query result presentation:

After the user specifies his request (departure location, destination location, day, time and number of passengers [see figure mainView.png]) the backend system will answers with a list of possible rides that meet the user's query. The mobile App displays such lists (ridelistview.png) and gives the possibility to the user to create a new ride, if none of the suggests rides are satisfactory for him/her.

##Creation of a new ride:

Triggering the "Create ride anyway" button will create a new ride in the backend system. This ride will be available for other users to join. When a minimum amount of users have joined the ride, the ride becomes confirmed and all users are informed and charged.

If a ride is created successfully a confirmation is displayed (ridecreated.png) and the ride is added to the backend database. After this point, users who want to join this ride should pay as soon as they joined the ride.

##Payment procedure

As the system's users join or create a ride their are charged for the price of the ride but the payment remains pending until the ride is confirmed of the users cancels his request. If the ride is confirmed the full price (divied between the users) is charged and billed. If the user cancels his request before his ride is confirmed the pending payment is withdrawed.

##Canceling a request

As long as a ride is not confirmed the users can cancel the requests without any charge. though once a ride is confirmed, users will be billed with the price of that ride even though they will not take the ride. 

#API’s and Data sources
To realize our service we have used the CommuteGreener API to calculate the amount of CO2 emissions for every passenger of a ride. We would have liked to implement a comparison showing the advantage of using this mean of travelling compared to others (private car/taxi and bus).

We would have liked to use the Telenor API to give confirmation of a confirmed ride, to give confirmation of the creating ad status of a ride to the user.

#Contribution to the Developer Recognition Award (if the team competes in this award)

//INTENTIONALLY EMPTY

#Self-estimation of the status of service completeness
The Mobile Application is 80% complete. The basic functionalities (described above) are in place, minor and trivial additions are needed to complete it. We estimate that a mere 12h could be enough to finish it.

The Backend functionalities to support the mobile Application are in place. However the results returned are not processed by any sorting algorithm (e.g. all rides are returned independendly of the query). We believe that the backend is 50% complete. We estimate that another 24 hours could be enough to implement all the functionalities and complete the service.