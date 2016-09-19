# F3 PowerDNS Web Interface

Web interface for the PowerDNS server (with a MySQL backend) built using the Fat Free Framework (F3). Built it as a way of teaching myself F3. Allows you to administrate your PowerDNS install via a pretty web front end, supports (hopefully) International Domains as well as regular domains.

## What's It All About?

[PowerDNS](https://powerdns.com/) is a great DNS server available for linux, it allows you to use various Backends instead of just a normal bind style zone file. I have been using it for a while and decided to write my own web front end for administering my domains, the original one I wrote was functional but horrific and the code for that will never see the light of day.

I decided to learn Fat Free Framework after being recommended it by a few people, so I combined the 2 projects and thus this little(?!) project was born.

The aim is to provide a fully functional web interface that you can just drop onto your server and easily allow you and your customers to do all your DNSy stuff.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Todo

Pretty much everything, currently only part of the DNS Admin stuff works, it is a work in progress.

#### Site Admin
- [x] Add Domains
- [x] Edit Domains
- [x] Delete Domains
- [ ] Add Users
- [ ] Edit Users
- [ ] Delete Users

#### Domain Admin
- [ ] Add Domains
- [ ] Edit Domains
- [ ] Delete Domains
- [ ] Add Users
- [ ] Edit Users
- [ ] Delete Users

#### Domain User
- [ ] Edit Domain

### Prerequisities

You will need to make sure you have installed and working the following

```
PowerDNS (with MySQL backend)
Nginx (or Apache) webserver
MySQL
php5-idn
php5-intl package / php5-idn
```

### Installing

Read the INSTALL.md in the install folder

## Built With

PHP
* [Fat Free Framework](https://fatfreeframework.com)

JS
* [JQuery](https://jquery.com/)
* [PNotify](https://sciactive.com/pnotify/)
* [Datatables](https://datatables.net)
* [Select2](select2.github.io)
* [X-Editable](https://vitalets.github.io/x-editable/)

HTML/CSS
* [Bootstrap](https://getbootstrap.com)
* [AdminLTE](https://almsaeedstudio.com/)

## Credit To

* **Lukas Metzger** - Totally ripped some of his Javascript from his [PDNS Manager](https://pdnsmanager.lmitsystems.de/). 

## Authors

* **Mr Sleeps** - [MrSleeps](https://github.com/MrSleeps)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
