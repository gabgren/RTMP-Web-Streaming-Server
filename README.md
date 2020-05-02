# RTMP-Web-Streaming-Server

Basic setup of a streaming server in RTMP and HLS, plus an HTTP web server with video player with admin section and unique sessions

## Installation

1. Configure Apache2 to make the web server run
2. Install nginx server and plugin
```
sudo apt install nginx
sudo add-apt-repository universe
sudo apt install libnginx-mod-rtmp
```
3. Configure Nginx to create a RTMP/HLS server. See [nginx-config.md](nginx-config.md)
4. Restart nginx: 
```
sudo systemctl restart nginx
```


## Usage
+ Edit config.php to change admin password
+ Navigate to /admin to create a session
+ Stream to the indicated url
+ Use the generated session URL to play the live stream

## TODO
+ I suggest you implement a better admin section protection/login system. This is for demo only
+ Web stream is HTTP only for now, no HTTPS