# Nginx Configuration
You can replace `/etc/nginx/nginx.conf` with this file.
This config will stream RTMP on default port 1935, as well as HLS for the web on port 8888

```
load_module "modules/ngx_rtmp_module.so";

worker_processes  auto;
events {
        worker_connections  1024;
}

# RTMP configuration
rtmp {
        server {
                listen 1935; # Listen on standard RTMP port
                chunk_size 4000;

                application session {
                        live on;
                        # Turn on HLS
                        hls on;
                        hls_path /mnt/session/;
                        hls_fragment 1s;
                        hls_playlist_length 60;
                }
        }
}

http {
        sendfile off;
        tcp_nopush on;
        directio 512;
        default_type application/octet-stream;

        server {
                listen 8888;

                location / {
                        # Disable cache
                        add_header 'Cache-Control' 'no-cache';

                        # CORS setup
                        add_header 'Access-Control-Allow-Origin' '*' always;
                        add_header 'Access-Control-Expose-Headers' 'Content-Length';

                        # allow CORS preflight requests
                        if ($request_method = 'OPTIONS') {
                                add_header 'Access-Control-Allow-Origin' '*';
                                add_header 'Access-Control-Max-Age' 1728000;
                                add_header 'Content-Type' 'text/plain charset=UTF-8';
                                add_header 'Content-Length' 0;
                                return 204;
                        }

                        types {
                                application/dash+xml mpd;
                                application/vnd.apple.mpegurl m3u8;
                                video/mp2t ts;
                        }
                        root /mnt/;

                }
        }
}
```