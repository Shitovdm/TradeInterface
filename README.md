![PriceHelper](https://raw.githubusercontent.com/Shitovdm/TradeInterface/images/image.png) #TradeInterface  
***  

**The project was canceled because of the innovations in the Steam exchange system. Now all the source files are available for free editing.**  

The project was created to automate trade on trading platforms of game items. It is implemented in the form of an interface in which it is convenient to regulate the process of buying and selling items.  

<h3>Capabilities</h3> 

- Purchase and sale of game items on the trading platform Steam.  
- Possibility of placing orders for sale and purchase of items.  
- Automatic updating of prices for exhibited items.  
- Buying and selling items on the platform CSGO.tm.  
- Automatic withdrawal of items from the trading platform CSGO.tm.  
- Automatic search for a variety of parameters of the most profitable items.  
- A lot of parameters for choosing categories, which are used to find the most profitable things.  
- A lot of adjustable parameters, allowing you to customize the interface for yourself.  
- Maintaining statistics of both sold and purchased items.  
- Automatic calculation of the money received and spent (both in percentage and in numbers).  
- The personal cabinet of each user with statistics and confidential data for trading.  
- The ability to memorize and exclude an item from the resale process.  

<h3>Engine</h3>  

Interface is completely built in the pure language of PHP without using third-party frameworks. Most pages are built dynamically, and only a small part of the statically loaded. A complex file structure is divided into logical folders that are responsible for a specific part of the interface.  

The project provides the ability to work with multiple accounts at the same time. Authorization consists of internal and third-party, using Steam API. User data is stored in the database in several distributed tables.  

If you work with the sale or purchase of things on the trading platform Steam, you will be able to find many already implemented methods of performing certain operations. To work with the trading platform is used the CURL. All requests to the site servers were sniffed, in the future, all the headers and necessary data were applied to correctly build queries from the project interface.  

To work with the trading platform CSGO.tm, used built-in API. It is quite simple and communication with servers is also carried out through the CURL. Details on working with the API can be found on the website https://market.csgo.com/docs/   

<h3>Interface</h3>

The entire functionality of the project is divided into several broken logical pages. In the following composition:  
- Searching/bot CSGO.tm -> Steam;  
- Searching/bot Steam -> CSGO.tm (orders);  
- Searching/bot Steam -> CSGO.tm (sell);  
- Statistic Steam -> CSGO.tm;  
- Statistic CSGO.tm -> Steam;  
- Profile;  
The interface is not simple and can cause difficulties with the first experience of use.  

<h3>Database</h3>


<h3>Resources:</h3>  
>> **https://market.csgo.com/docs/** - CSGO.tm open API.  
>> **https://github.com/SmItH197/SteamAuthentication** - PHP Steam Auth.  
>> **https://github.com/Jessecar96/SteamDesktopAuthenticator/releases** - Steam Desktop Authenticator.  
