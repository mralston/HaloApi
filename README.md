<a name="readme-top"></a>

<p align="center">
    <a href="https://github.com/derricksmith/HaloApi/contributors">
        <img src="https://img.shields.io/github/contributors/derricksmith/HaloApi.svg?style=for-the-badge" alt="Contributors" /></a>
    <a href="https://github.com/derricksmith/HaloApi/network/members">
        <img src="https://img.shields.io/github/forks/derricksmith/HaloApi.svg?style=for-the-badge" alt="Forks" /></a>
    <a href="https://github.com/derricksmith/HaloApi/stargazers">
        <img src="https://img.shields.io/github/stars/derricksmith/HaloApi.svg?style=for-the-badge" alt="Stars" /></a>
    <a href="https://github.com/derricksmith/HaloApi/issues">
        <img src="https://img.shields.io/github/issues/derricksmith/HaloApi.svg?style=for-the-badge" alt="Issues" /></a>
    <a href="https://github.com/derricksmith/HaloApi/blob/master/LICENSE.txt">
        <img src="https://img.shields.io/github/license/derricksmith/HaloApi.svg?style=for-the-badge" alt="License" /></a>
    <a href="https://www.linkedin.com/in/derrick-smith-cissp-cism-9b355b56/">
        <img src="https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555" alt="LinkedIn"/></a>
</p>

<p align="center">
    <a href="https://twitter.com/intent/follow?screen_name=derrick_a_smith">
        <img src="https://img.shields.io/twitter/follow/derrick_a_smith?style=social&logo=twitter"
            alt="follow on Twitter"></a>
</p>


<div align="center">

<h3 align="center">HaloAPI</h3>
  
HaloApi is a PHP Wrapper for the HaloITSM API.  This class supports all endpoints and methods available in the API.  

</div>


<!-- ABOUT THE PROJECT -->

## About The Project


HaloITSM is a powerful ITIL aligned IT Service Management tool.  The REST API provides access to various information in the system.  This wrapper was created to make calling the HaloITSM API easier and faster.   

  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>



<!-- GETTING STARTED -->

## Getting Started


### Prerequisites

  

The following PHP extensions are required:

* curl
* json


<!-- USAGE EXAMPLES -->

## Usage

### Install with Composer

```
composer require mralston/haloapi
```

### Vanilla PHP

Instantiate the class with the following parameters.  See the [HaloITSM API documentation](https://halo.haloservicedesk.com/apidoc/info) for more information. 

client_id
client_secret
grant_type
scope
host
verifypeer

```
$halo = new HaloApi([
	'client_id' => '<your client id>', 
	'client_secret' => '<your client secret>', 
	'grant_type' => '<your grant type>',
	'scope' => '<your scope>',
	'host' => '<your Halo ITSM base URL>', 
	'verifypeer' => true
]);	
```

Then call an endpoint method in the class.
```
$tickets = $halo->getTickets([
    'pageinate' => true,
	'page_size' => 50,
	'page_no' => 1,
	'columns_id' => 1,
	'includecolumns' => false,
	'ticketlinktype' => null,
	'searchactions' => null,
	'order' => 'id',
]);

// Returns array with response headers and data
[
    "status": 200,
    "header": ""
      HTTP/2 200
      date: Thu, 01 Jan 1970 00:00:00 GMT
      content-type: application/json; charset=utf-8
      content-length: 56
      cache-control: no-cache, no-store, must-revalidate
      server: 
      request-context: appId=cid-v1:aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa
      strict-transport-security: max-age=31536000; IncludeSubDomains; preload
      referrer-policy: same-origin
      permissions-policy: camera=(self),geolocation=(self)
      "",
    "data": {
       "record_count": 0,
       "tickets": [],
       "include_children": false,
    },
  ]
```

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>

### Laravel

The package contains an optional Laravel-specific service provider, config file & facade.

Once the package is installed, add the following variables to your .env file:

```dotenv
HALO_CLIENT_ID=
HALO_CLIENT_SECRET=
HALO_HOST=https://your-subdomain.haloitsm.com
```

Optionally, you can publish the config file:

```bash
php artisan vendor:publish --tag="halo-config"
```

You may then use the facade to interact with Halo:

```php
use DerrickSmith\HaloApi\Facades\HaloApi;

$tickets = HaloApi::getTickets([
    'pageinate' => true,
    'page_size' => 50,
    'page_no' => 1,
    'columns_id' => 1,
    'includecolumns' => false,
    'ticketlinktype' => null,
    'searchactions' => null,
    'order' => 'id',
]);

// Returns data object
{
    "record_count": 0,
    "tickets": [],
    "include_children": false,
}
```

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>

  
  
  

<!-- ROADMAP -->

## Roadmap

  

- [ ] Testing all api endpoints

- [ ] Better error handling



  

See the [open issues](https://github.com/derricksmith/HaloApi/issues) for a full list of proposed features (and known issues).

  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>

  
  
  

<!-- CONTRIBUTING -->

## Contributing

  

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

  

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".

Don't forget to give the project a star! Thanks again!

  

1. Fork the Project

2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)

3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)

4. Push to the Branch (`git push origin feature/AmazingFeature`)

5. Open a Pull Request

  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>

  
  
  

<!-- LICENSE -->

## License

  

Distributed under the MIT License. See `LICENSE.txt` for more information.

  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>

  
  
  

<!-- CONTACT -->

## Contact

  

Derrick Smith - [@derrick_a_smith](https://twitter.com/derrick_a_smith) - derricksmith01@msn.com

  

Project Link: [https://github.com/derricksmith/HaloApi](https://github.com/derricksmith/HaloApi)

  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>

  
  
  

<!-- ACKNOWLEDGMENTS -->

## Acknowledgments

* [Jordi Moraleda - PHP Rest Curl](https://github.com/jmoraleda/php-rest-curl)
  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p> 



  
  
  

<!-- MARKDOWN LINKS & IMAGES -->

<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/derricksmith/HaloApi.svg?style=for-the-badge
[contributors-url]: https://github.com/derricksmith/HaloApi/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/derricksmith/HaloApi.svg?style=for-the-badge
[forks-url]: https://github.com/derricksmith/HaloApi/network/members
[stars-shield]: https://img.shields.io/github/stars/derricksmith/HaloApi.svg?style=for-the-badge
[stars-url]: https://github.com/derricksmith/HaloApi/stargazers
[issues-shield]: https://img.shields.io/github/issues/derricksmith/HaloApi.svg?style=for-the-badge
[issues-url]: https://github.com/derricksmith/HaloApi/issues
[license-shield]: https://img.shields.io/github/license/derricksmith/HaloApi.svg?style=for-the-badge
[license-url]: https://github.com/derricksmith/HaloApi/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/derrick-smith-cissp-cism-9b355b56/
[product-screenshot]: images/screenshot.png
[Next.js]: https://img.shields.io/badge/next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white
[Next-url]: https://nextjs.org/
[React.js]: https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB
[React-url]: https://reactjs.org/
[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org/
[Angular.io]: https://img.shields.io/badge/Angular-DD0031?style=for-the-badge&logo=angular&logoColor=white
[Angular-url]: https://angular.io/
[Svelte.dev]: https://img.shields.io/badge/Svelte-4A4A55?style=for-the-badge&logo=svelte&logoColor=FF3E00
[Svelte-url]: https://svelte.dev/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com
