When I shut down [Knight's Adventure](http://web.archive.org/web/20070526053256/http://www.knightsadventure.com/login.php) (which is worthy of a post in itself) it was hosted on several of [Rackspace's](https://www.rackspace.com/) cloud servers. It had two HA load balancers (this predates their new built in load-balancers-as-a-service) that served the requests to one of five PHP application servers and had one really big MySQL database server (I could never get master slaves/cluster to work back then). Toward the end I put a few [Redis](https://redis.io/) cache nodes on each of the PHP servers to handle both the PHP sessions and some non-changing global data for the game.

That was costing several hundred per month in hosting costs alone and my tiny blog didn't need anywhere close to that kind of setup. I saw a $14/year VPS offer on [LowEndBox](https://lowendbox.com/) from [Secure Dragon](https://securedragon.net/) that included:

1. 96MB guaranteed/192MB burstable RAM
2. 5GB storage
3. 100GB/month data transfer
4. OpenVZ/SolusVM

Hard to beat for roughly $1.16 a month. This domain and Knight's Adventure's have been served by them every since. Last year sometime they changed plans around a bit and I ended up on the $14.99/year:

1. 128MB RAM
2. 10GB storage
3. 500GB/month data transfer
4. OpenVZ/SolusVM

I've been a happy customer since 2011 and will most likely continue to keep that my VPS, as I keep a backup of some important files on there.

This blog however is hosted on one [Vultr's](https://www.vultr.com/) *sandbox* 512MB cloud servers. I like cloud servers. The ability to spin up a test instance and destroy it and only pay for the time used is super handy. When I checked out Rackspace again, their [cheapest instance](https://www.rackspace.com/en-us/openstack/public/pricing) (at 1GB RAM) was ~$27 a month. I compared all the [top cloud hosting providers](http://www.servermom.org/low-end-cloud-server-providers/) these days. While I liked [DigiatalOcean](https://www.digitalocean.com) and [Linode](https://www.linode.com/), the 15 locations worldwide, spanning North America, Europe, Asia and Australia and the cheap $2.50/month (limit of 2) servers were what made me go with Vultr. 
