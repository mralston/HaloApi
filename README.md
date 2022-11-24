<!-- Improved compatibility of back to top link: See: https://github.com/othneildrew/Best-README-Template/pull/73 -->

<a  name="readme-top"></a>

<!--

*** Thanks for checking out the Best-README-Template. If you have a suggestion

*** that would make this better, please fork the repo and create a pull request

*** or simply open an issue with the tag "enhancement".

*** Don't forget to give the project a star!

*** Thanks again! Now go create something AMAZING! :D

-->

  
  
  

<!-- PROJECT SHIELDS -->

<!--

*** I'm using markdown "reference style" links for readability.

*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).

*** See the bottom of this document for the declaration of the reference variables

*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.

*** https://www.markdownguide.org/basic-syntax/#reference-style-links

-->

<p align="center">
    <a href="https://github.com/derricksmith/HaloApi/contributors" alt="Contributors">
        <img src="https://img.shields.io/github/contributors/derricksmith/HaloApi.svg?style=for-the-badge" /></a>
    
    <a href="https://github.com/derricksmith/HaloApi/network/members" alt="Forks">
        <img src="https://img.shields.io/github/forks/derricksmith/HaloApi.svg?style=for-the-badge" /></a>
    
    <a href="#sponsors" alt="Sponsors on Open Collective">
        <img src="https://img.shields.io/opencollective/sponsors/shields" /></a>
    
    <a href="https://github.com/badges/shields/pulse" alt="Activity">
        <img src="https://img.shields.io/github/commit-activity/m/badges/shields" /></a>
    
    <a href="https://circleci.com/gh/badges/shields/tree/master">
        <img src="https://img.shields.io/circleci/project/github/badges/shields/master" alt="build status"></a>
    
    <a href="https://circleci.com/gh/badges/daily-tests">
        <img src="https://img.shields.io/circleci/project/github/badges/daily-tests?label=service%20tests"
            alt="service-test status"></a>
	
    <a href="https://coveralls.io/github/badges/shields">
        <img src="https://img.shields.io/coveralls/github/badges/shields"
            alt="coverage"></a>
    <a href="https://lgtm.com/projects/g/badges/shields/alerts/">
        <img src="https://img.shields.io/lgtm/alerts/g/badges/shields"
            alt="Total alerts"/></a>
    <a href="https://discord.gg/HjJCwm5">
        <img src="https://img.shields.io/discord/308323056592486420?logo=discord"
            alt="chat on Discord"></a>
    <a href="https://twitter.com/intent/follow?screen_name=shields_io">
        <img src="https://img.shields.io/twitter/follow/shields_io?style=social&logo=twitter"
            alt="follow on Twitter"></a>
</p>

<p align="center">

[![Contributors][contributors-shield]][contributors-url]

[![Forks][forks-shield]][forks-url]

[![Stargazers][stars-shield]][stars-url]

[![Issues][issues-shield]][issues-url]

[![MIT License][license-shield]][license-url]

[![LinkedIn][linkedin-shield]][linkedin-url]

</p>
  

<!-- PROJECT LOGO -->

<br  />

<div  align="center">


<h3  align="center">HaloAPI</h3>
  

<p  align="center">

HaloApi is a PHP Wrapper for the HaloITSM API.  This class supports all endpoints and methods available in the API.  


·

<a href="https://github.com/github_username/repo_name/issues">Report Bug</a>

·

<a href="https://github.com/github_username/repo_name/issues">Request Feature</a>

</p>

</div>

  
  
  

<!-- TABLE OF CONTENTS -->

<details>

<summary>Table of Contents</summary>

<ol>

<li>

<a  href="#about-the-project">About The Project</a>

</li>

<li>

<a  href="#getting-started">Getting Started</a>

<ul>

<li><a  href="#prerequisites">Prerequisites</a></li>

<li><a  href="#installation">Installation</a></li>

</ul>

</li>

<li><a href="#usage">Usage</a></li>

<li><a href="#roadmap">Roadmap</a></li>

<li><a href="#contributing">Contributing</a></li>

<li><a href="#license">License</a></li>

<li><a href="#contact">Contact</a></li>

</ol>

</details>

  
  
  

<!-- ABOUT THE PROJECT -->

## About The Project

  

[![Product Name Screen Shot][product-screenshot]](https://example.com)

  

Here's a blank template to get started: To avoid retyping too much info. Do a search and replace with your text editor for the following: `github_username`, `repo_name`, `twitter_handle`, `linkedin_username`, `email_client`, `email`, `project_title`, `project_description`

  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p>



<!-- GETTING STARTED -->

## Getting Started

  





### Prerequisites

  

The PHP curl extension is required.

* php curl



  



<!-- USAGE EXAMPLES -->

## Usage

Include the class in your project.  

```
require HaloApi.class.php
```

Then instantiate the class with the following parameters.  See the [HaloITSM API documentation](https://halo.haloservicedesk.com/apidoc/info) for more information. 

client_id
client_secret
grant_type
scope
host
verifypeer

```
$halo = new HaloApi(array(
	'client_id' => '<your client id>', 
	'client_secret' => '<your client secret>', 
	'grant_type' => '<your grant type>',
	'scope' => '<your scope>',
	'host' => '<your Halo ITSM base URL>', 
	'verifypeer' => true
));	
```

Then call an endpoint method in the class.
```
$request = array(
	'pageinate' => true,
	'page_size' => 50,
	'page_no' => 1,
	'columns_id' => 1,
	'includecolumns' => false,
	'ticketlinktype' => null,
	'searchactions' => null,
	'order' => 'id',
);
$tickets = $halo->getTickets($request);
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

<!-- ## Acknowledgments

  

* []()

* []()

* []()

  

<p  align="right">(<a  href="#readme-top">back to top</a>)</p> 

-->

  
  
  

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
