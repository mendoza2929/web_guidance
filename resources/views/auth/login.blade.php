<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GOLink</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>
<style>
    @import 'https://fonts.googleapis.com/css?family=Open+Sans|Quicksand:400,700';
    p.field {
    position: relative;
}

p.field span {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #555; /* Adjust color if needed */
}


    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body,
    html {
        height: 100%;
        font-family: 'Quicksand', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    body {
        background: rgba(30, 29, 31, 1);
        background: -moz-linear-gradient(-45deg, rgba(30, 29, 31, 1) 0%, rgba(223, 64, 90, 1) 100%);
        background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(30, 29, 31, 1)), color-stop(100%, rgba(223, 64, 90, 1)));
        background: -webkit-linear-gradient(-45deg, rgba(30, 29, 31, 1) 0%, rgba(223, 64, 90, 1) 100%);
        background: -o-linear-gradient(-45deg, rgba(30, 29, 31, 1) 0%, rgba(223, 64, 90, 1) 100%);
        background: -ms-linear-gradient(-45deg, rgba(30, 29, 31, 1) 0%, rgba(223, 64, 90, 1) 100%);
        background: linear-gradient(135deg, rgba(30, 29, 31, 1) 0%, rgba(223, 64, 90, 1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#1e1d1f', endColorstr='#df405a', GradientType=1);
    }

    /*--------------------
Text
---------------------*/

    h2,
    h3 {
        font-size: 16px;
        letter-spacing: -1px;
        line-height: 20px;
    }

    h2 {
        color: #747474;
        text-align: center;
    }

    h3 {
        color: #032942;
        text-align: right;
    }

    /*--------------------
Icons
---------------------*/
    .i {
        width: 20px;
        height: 20px;
    }

    .i-login {
        margin: 13px 0px 0px 15px;
        position: relative;
        float: left;
        background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCIgdmlld0JveD0iMCAwIDQxNi4yMjkgNDE2LjIyOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDE2LjIyOSA0MTYuMjI5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQwMy43MjksMjkuNjVINzEuODAyYy02LjkwMywwLTEyLjUsNS41OTctMTIuNSwxMi41djg2LjM2M2MwLDYuOTAzLDUuNTk3LDEyLjUsMTIuNSwxMi41czEyLjUtNS41OTcsMTIuNS0xMi41VjU0LjY1ICAgIGgzMDYuOTI3djMwNi45MjhIODQuMzAydi03My44NjFjMC02LjkwMy01LjU5Ny0xMi41LTEyLjUtMTIuNXMtMTIuNSw1LjU5Ny0xMi41LDEyLjV2ODYuMzYxYzAsNi45MDMsNS41OTcsMTIuNSwxMi41LDEyLjUgICAgaDMzMS45MjdjNi45MDIsMCwxMi41LTUuNTk3LDEyLjUtMTIuNVY0Mi4xNUM0MTYuMjI5LDM1LjI0Nyw0MTAuNjMxLDI5LjY1LDQwMy43MjksMjkuNjV6IiBmaWxsPSIjODczMTRlIi8+CgkJPHBhdGggZD0iTTE4NS40MTcsMjg3LjgxMWMwLDUuMDU3LDMuMDQ1LDkuNjEzLDcuNzE2LDExLjU1YzEuNTQ3LDAuNjQyLDMuMTcsMC45NSw0Ljc4MSwwLjk1YzMuMjUzLDAsNi40NTEtMS4yNyw4Ljg0Mi0zLjY2ICAgIGw3OS42OTctNzkuNjk3YzIuMzQ0LTIuMzQ0LDMuNjYtNS41MjMsMy42Ni04LjgzOWMwLTMuMzE2LTEuMzE2LTYuNDk1LTMuNjYtOC44MzlsLTc5LjY5Ny03OS42OTcgICAgYy0zLjU3NS0zLjU3NS04Ljk1MS00LjY0Ni0xMy42MjMtMi43MWMtNC42NzEsMS45MzYtNy43MTYsNi40OTMtNy43MTYsMTEuNTQ5djY3LjE5N0gxMi41Yy02LjkwMywwLTEyLjUsNS41OTctMTIuNSwxMi41ICAgIGMwLDYuOTAzLDUuNTk3LDEyLjUsMTIuNSwxMi41aDE3Mi45MTdWMjg3LjgxMUwxODUuNDE3LDI4Ny44MTF6IE0yMTAuNDE3LDE1OC41OTRsNDkuNTIxLDQ5LjUybC00OS41MjEsNDkuNTIxVjE1OC41OTR6IiBmaWxsPSIjODczMTRlIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
        background-size: 18px 18px;
        background-repeat: no-repeat;
        background-position: center;
    }

    .i-more {
        background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCIgdmlld0JveD0iMCAwIDYxMiA2MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA2MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0ibW9yZSI+CgkJPGc+CgkJCTxwYXRoIGQ9Ik03Ni41LDIyOS41QzM0LjMsMjI5LjUsMCwyNjMuOCwwLDMwNnMzNC4zLDc2LjUsNzYuNSw3Ni41UzE1MywzNDguMiwxNTMsMzA2UzExOC43LDIyOS41LDc2LjUsMjI5LjV6IE03Ni41LDM0NC4yICAgICBjLTIxLjEsMC0zOC4yLTE3LjEwMS0zOC4yLTM4LjJjMC0yMS4xLDE3LjEtMzguMiwzOC4yLTM4LjJzMzguMiwxNy4xLDM4LjIsMzguMkMxMTQuNywzMjcuMSw5Ny42LDM0NC4yLDc2LjUsMzQ0LjJ6ICAgICAgTTUzNS41LDIyOS41Yy00Mi4yLDAtNzYuNSwzNC4zLTc2LjUsNzYuNXMzNC4zLDc2LjUsNzYuNSw3Ni41UzYxMiwzNDguMiw2MTIsMzA2UzU3Ny43LDIyOS41LDUzNS41LDIyOS41eiBNNTM1LjUsMzQ0LjIgICAgIGMtMjEuMSwwLTM4LjItMTcuMTAxLTM4LjItMzguMmMwLTIxLjEsMTcuMTAxLTM4LjIsMzguMi0zOC4yczM4LjIsMTcuMSwzOC4yLDM4LjJDNTczLjcsMzI3LjEsNTU2LjYsMzQ0LjIsNTM1LjUsMzQ0LjJ6ICAgICAgTTMwNiwyMjkuNWMtNDIuMiwwLTc2LjUsMzQuMy03Ni41LDc2LjVzMzQuMyw3Ni41LDc2LjUsNzYuNXM3Ni41LTM0LjMsNzYuNS03Ni41UzM0OC4yLDIyOS41LDMwNiwyMjkuNXogTTMwNiwzNDQuMiAgICAgYy0yMS4xLDAtMzguMi0xNy4xMDEtMzguMi0zOC4yYzAtMjEuMSwxNy4xLTM4LjIsMzguMi0zOC4yYzIxLjEsMCwzOC4yLDE3LjEsMzguMiwzOC4yQzM0NC4yLDMyNy4xLDMyNy4xLDM0NC4yLDMwNiwzNDQuMnoiIGZpbGw9IiNkZjQwNWEiLz4KCQk8L2c+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
        background-size: 20px 20px;
        background-repeat: no-repeat;
        background-position: center;
    }

    .i-save {
        background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCIgdmlld0JveD0iMCAwIDYxMiA2MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA2MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0idGljayI+CgkJPGc+CgkJCTxwYXRoIGQ9Ik00MzYuNywxOTYuNzAxTDI1OC4xODgsMzc1LjIxM2wtODIuODY5LTgyLjg4N2MtNy4yODctNy4yODctMTkuMTI1LTcuMjg3LTI2LjQxMiwwcy03LjI4NywxOS4xMjUsMCwyNi40MTIgICAgIGw5My44MDgsOTMuODA4YzAuNjMxLDAuODk5LDEuMDE0LDEuOTMyLDEuODE3LDIuNzM1YzMuNzY4LDMuNzY4LDguNzIxLDUuNTA4LDEzLjY1NSw1LjM3NGM0LjkzNCwwLjExNSw5LjkwNy0xLjYwNiwxMy42NzQtNS4zNzQgICAgIGMwLjgwMy0wLjgwNCwxLjE4Ni0xLjgzNiwxLjgxNy0yLjczNWwxODkuNDM0LTE4OS40MzNjNy4yODYtNy4yODcsNy4yODYtMTkuMTI1LDAtMjYuNDEyICAgICBDNDU1LjgwNiwxODkuNDE0LDQ0My45ODcsMTg5LjQxNCw0MzYuNywxOTYuNzAxeiBNMzA2LDBDMTM2Ljk5MiwwLDAsMTM2Ljk5MiwwLDMwNnMxMzYuOTkyLDMwNiwzMDYsMzA2ICAgICBjMTY4Ljk4OCwwLDMwNi0xMzYuOTkyLDMwNi0zMDZTNDc1LjAwOCwwLDMwNiwweiBNMzA2LDU3My43NUMxNTguMTI1LDU3My43NSwzOC4yNSw0NTMuODc1LDM4LjI1LDMwNiAgICAgQzM4LjI1LDE1OC4xMjUsMTU4LjEyNSwzOC4yNSwzMDYsMzguMjVjMTQ3Ljg3NSwwLDI2Ny43NSwxMTkuODc1LDI2Ny43NSwyNjcuNzVDNTczLjc1LDQ1My44NzUsNDUzLjg3NSw1NzMuNzUsMzA2LDU3My43NXoiIGZpbGw9IiMyMGMxOTgiLz4KCQk8L2c+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
        background-size: 20px 20px;
        background-repeat: no-repeat;
        background-position: center;
    }

    .i-warning {
        background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDYxMi44MTYgNjEyLjgxNiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNjEyLjgxNiA2MTIuODE2OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCI+CjxnPgoJPHBhdGggZD0iTTMwNi40MDgsMEMxMzcuMzY4LDAsMC4zNzEsMTM2Ljk5NywwLjM3MSwzMDYuMDM3czEzNi45OTcsMzA2Ljc3OSwzMDYuMDM3LDMwNi43NzlzMzA2LjAzNy0xMzcuODEzLDMwNi4wMzctMzA2LjAzNyAgIEM2MTIuNDQ1LDEzNy43MzksNDc1LjQ0OCwwLDMwNi40MDgsMHogTTMwNi40MDgsNTgzLjE0N2MtMTUyLjIwMywwLTI3Ni4zNjgtMTI0LjE2NS0yNzYuMzY4LTI3Ni4zNjggICBTMTU0LjIwNSwyOS41OTUsMzA2LjQwOCwyOS41OTVTNTgyLjc3NiwxNTMuNzYsNTgyLjc3NiwzMDYuNzc5UzQ1OC42MTEsNTgzLjE0NywzMDYuNDA4LDU4My4xNDd6IE0zMjEuNjEzLDQzMS43NiAgIGMwLDguODI3LTcuMTk1LDE2LjAyMS0xNi4wMjEsMTYuMDIxYy04LjgyNywwLTE2LjAyMS03LjE5NS0xNi4wMjEtMTYuMDIxYzAtOC44MjcsNy4xOTUtMTYuMDIxLDE2LjAyMS0xNi4wMjEgICBTMzIxLjYxMyw0MjIuOTM0LDMyMS42MTMsNDMxLjc2eiBNMjkwLjM4NywzNTMuMjExdi0xODAuMjRjMC04LjAxMSw2LjM3OS0xNC4zOSwxNC4zOS0xNC4zOWM4LjAxMSwwLDE0LjM5LDYuMzc5LDE0LjM5LDE0LjM5ICAgdjE4MC4yNGMwLDguMDExLTYuMzc5LDE0LjM5LTE0LjM5LDE0LjM5QzI5Ni43NjYsMzY4LjQ5MSwyOTAuMzg3LDM2MS4yMjIsMjkwLjM4NywzNTMuMjExeiIgZmlsbD0iI2Y1ZDg3OCIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=);
        background-size: 20px 20px;
        background-repeat: no-repeat;
        background-position: center;
    }

    .i-close {
        background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDYxMi40NDUgNjEyLjQ0NSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNjEyLjQ0NSA2MTIuNDQ1OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCI+CjxnPgoJPHBhdGggZD0iTTUyMi42NDIsODkuODA0QzQ2NC45LDMyLjA2MiwzODguMDExLDAsMzA2LjIyMywwUzE0Ny41NDUsMzIuMDYyLDg5LjgwNCw4OS44MDQgICBjLTExOS40MTYsMTE5LjQxNi0xMTkuNDE2LDMxMy40MjIsMCw0MzIuODM4YzU3Ljc0MSw1Ny43NDEsMTM0LjYzMSw4OS44MDQsMjE2LjQxOSw4OS44MDRzMTU4LjY3OC0zMi4wNjIsMjE2LjQxOS04OS44MDQgICBDNjQyLjA1OCw0MDMuMjI1LDY0Mi4wNTgsMjA5LjIyLDUyMi42NDIsODkuODA0eiBNNTAxLjc4Nyw1MDEuNzg3Yy01Mi4xMDEsNTIuMTAxLTEyMS43OTEsODAuOTcyLTE5NS41NjQsODAuOTcyICAgcy0xNDMuNDYzLTI4Ljg3MS0xOTUuNTY0LTgwLjk3MlMyOS42ODcsMzc5Ljk5NSwyOS42ODcsMzA2LjIyM3MyOC44NzEtMTQzLjQ2Myw4MC45NzItMTk1LjU2NHMxMjEuODY2LTgwLjk3MiwxOTUuNTY0LTgwLjk3MiAgIHMxNDMuNDYzLDI4Ljg3MSwxOTUuNTY0LDgwLjk3MnM4MC45NzIsMTIxLjg2Niw4MC45NzIsMTk1LjU2NFM1NTMuODg3LDQ0OS42ODYsNTAxLjc4Nyw1MDEuNzg3eiBNMzk5LjIxOCwyMzQuODk5bC03NC41MTUsNzQuNTE1ICAgbDc0LjUxNSw3NC41MTVjNS42NDEsNS42NDEsNS42NDEsMTUuMjE1LDAsMjAuODU1Yy0zLjE5MSwzLjE5MS02LjM4Myw0LjAwOC0xMC4zOTEsNC4wMDhjLTQuMDA4LDAtNy4xOTktMS42MzMtMTAuMzktNC4wMDggICBsLTc0LjU4OS03NC41MTVsLTc0LjU4OSw3NC41MTVjLTMuMTkxLDMuMTkxLTYuMzgzLDQuMDA4LTEwLjM5LDQuMDA4cy03LjE5OS0xLjYzMy0xMC4zOS00LjAwOCAgIGMtNS42NDEtNS42NDEtNS42NDEtMTUuMjE1LDAtMjAuODU1bDc0LjUxNS03NC41MTVsLTc0LjUxNS03NC41MTVjLTUuNjQxLTUuNjQxLTUuNjQxLTE1LjIxNSwwLTIwLjg1NSAgIGM1LjY0MS01LjY0MSwxNS4yMTUtNS42NDEsMjAuODU1LDBsNzQuNTE1LDc0LjUxNWw3NC41MTUtNzQuNTE1YzUuNjQxLTUuNjQxLDE1LjIxNS01LjY0MSwyMC44NTUsMCAgIEM0MDQuODU4LDIxOS42ODUsNDA0Ljg1OCwyMjguNDQyLDM5OS4yMTgsMjM0Ljg5OXoiIGZpbGw9IiNmNTVhNGUiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
        background-size: 20px 20px;
        background-repeat: no-repeat;
        background-position: center;
    }

    .i-left {
        background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCIgdmlld0JveD0iMCAwIDQxNC4yOTggNDE0LjI5OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDE0LjI5OCA0MTQuMjk5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTMuNjYzLDQxMC42MzdjMi40NDEsMi40NCw1LjY0LDMuNjYxLDguODM5LDMuNjYxYzMuMTk5LDAsNi4zOTgtMS4yMjEsOC44MzktMy42NjFsMTg1LjgwOS0xODUuODFsMTg1LjgxLDE4NS44MTEgICBjMi40NCwyLjQ0LDUuNjQxLDMuNjYxLDguODQsMy42NjFjMy4xOTgsMCw2LjM5Ny0xLjIyMSw4LjgzOS0zLjY2MWM0Ljg4MS00Ljg4MSw0Ljg4MS0xMi43OTYsMC0xNy42NzlsLTE4NS44MTEtMTg1LjgxICAgbDE4NS44MTEtMTg1LjgxYzQuODgxLTQuODgyLDQuODgxLTEyLjc5NiwwLTE3LjY3OGMtNC44ODItNC44ODItMTIuNzk2LTQuODgyLTE3LjY3OSwwbC0xODUuODEsMTg1LjgxTDIxLjM0LDMuNjYzICAgYy00Ljg4Mi00Ljg4Mi0xMi43OTYtNC44ODItMTcuNjc4LDBjLTQuODgyLDQuODgxLTQuODgyLDEyLjc5NiwwLDE3LjY3OGwxODUuODEsMTg1LjgwOUwzLjY2MywzOTIuOTU5ICAgQy0xLjIxOSwzOTcuODQxLTEuMjE5LDQwNS43NTYsMy42NjMsNDEwLjYzN3oiIGZpbGw9IiM4NzMxNGUiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K);
        background-size: 16px 16px;
        background-repeat: no-repeat;
        background-position: center;
    }

    /*--------------------
Login Box
---------------------*/

    .box {
        width: 330px;
        position: absolute;
        top: 50%;
        left: 50%;

        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .box-form {
        width: 320px;
        position: relative;
        z-index: 1;
    }

    .box-login-tab {
        width: 50%;
        height: 40px;
        background: #fdfdfd;
        position: relative;
        float: left;
        z-index: 1;

        -webkit-border-radius: 6px 6px 0 0;
        -moz-border-radius: 6px 6px 0 0;
        border-radius: 6px 6px 0 0;

        -webkit-transform: perspective(5px) rotateX(0.93deg) translateZ(-1px);
        transform: perspective(5px) rotateX(0.93deg) translateZ(-1px);
        -webkit-transform-origin: 0 0;
        transform-origin: 0 0;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;

        -webkit-box-shadow: 15px -15px 30px rgba(0, 0, 0, 0.32);
        -moz-box-shadow: 15px -15px 30px rgba(0, 0, 0, 0.32);
        box-shadow: 15px -15px 30px rgba(0, 0, 0, 0.32);
    }

    .box-login-title {
        width: 35%;
        height: 40px;
        position: absolute;
        float: left;
        z-index: 2;
    }

    .box-login {
        position: relative;
        top: -4px;
        width: 320px;
        background: #fdfdfd;
        text-align: center;
        overflow: hidden;
        z-index: 2;

        -webkit-border-top-right-radius: 6px;
        -webkit-border-bottom-left-radius: 6px;
        -webkit-border-bottom-right-radius: 6px;
        -moz-border-radius-topright: 6px;
        -moz-border-radius-bottomleft: 6px;
        -moz-border-radius-bottomright: 6px;
        border-top-right-radius: 6px;
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;

        -webkit-box-shadow: 15px 30px 30px rgba(0, 0, 0, 0.32);
        -moz-box-shadow: 15px 30px 30px rgba(0, 0, 0, 0.32);
        box-shadow: 15px 30px 30px rgba(0, 0, 0, 0.32);
    }

    .box-info {
        width: 260px;
        top: 60px;
        position: absolute;
        right: -5px;
        padding: 15px 15px 15px 30px;
        background-color: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 0;

        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;

        -webkit-box-shadow: 15px 30px 30px rgba(0, 0, 0, 0.32);
        -moz-box-shadow: 15px 30px 30px rgba(0, 0, 0, 0.32);
        box-shadow: 15px 30px 30px rgba(0, 0, 0, 0.32);
    }

    .line-wh {
        width: 100%;
        height: 1px;
        top: 0px;
        margin: 12px auto;
        position: relative;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
    }

    /*--------------------
Form
---------------------*/

    a {
        text-decoration: none;
    }

    button:focus {
        outline: 0;
    }

    .b {
        height: 24px;
        line-height: 24px;
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    .b-form {
        opacity: 0.5;
        margin: 10px 20px;
        float: right;
    }

    .b-info {
        opacity: 0.5;
        float: left;
    }

    .b-form:hover,
    .b-info:hover {
        opacity: 1;
    }

    .b-support,
    .b-cta {
        width: 100%;
        padding: 0px 15px;
        font-family: 'Quicksand', sans-serif;
        font-weight: 700;
        letter-spacing: -1px;
        font-size: 16px;
        line-height: 32px;
        cursor: pointer;

        -webkit-border-radius: 16px;
        -moz-border-radius: 16px;
        border-radius: 16px;
    }

    .b-support {
        border: #87314e 1px solid;
        background-color: transparent;
        color: #87314e;
        margin: 6px 0;
    }

    .b-cta {
        border: #df405a 1px solid;
        background-color: #df405a;
        color: #fff;
    }

    .b-support:hover,
    .b-cta:hover {
        color: #fff;
        background-color: #87314e;
        border: #87314e 1px solid;
    }

    .fieldset-body {
        display: table;
    }

    .fieldset-body p {
        width: 100%;
        display: inline-table;
        padding: 5px 20px;
        margin-bottom: 2px;
    }

    label {
        float: left;
        width: 100%;
        top: 0px;
        color: #032942;
        font-size: 13px;
        font-weight: 700;
        text-align: left;
        line-height: 1.5;
    }

    label.checkbox {
        float: left;
        padding: 5px 20px;
        line-height: 1.7;
    }

    input[type=text],
    input[type=password] {
        width: 100%;
        height: 32px;
        padding: 0px 10px;
        background-color: rgba(0, 0, 0, 0.03);
        border: none;
        display: inline;
        color: #303030;
        font-size: 16px;
        font-weight: 400;
        float: left;

        -webkit-box-shadow: inset 1px 1px 0px rgba(0, 0, 0, 0.05), 1px 1px 0px rgba(255, 255, 255, 1);
        -moz-box-shadow: inset 1px 1px 0px rgba(0, 0, 0, 0.05), 1px 1px 0px rgba(255, 255, 255, 1);
        box-shadow: inset 1px 1px 0px rgba(0, 0, 0, 0.05), 1px 1px 0px rgba(255, 255, 255, 1);
    }

    input[type=text]:focus,
    input[type=password]:focus {
        background-color: #f8f8c6;
        outline: none;
    }

    input[type=submit] {
        width: 100%;
        height: 48px;
        margin-top: 24px;
        padding: 0px 20px;
        font-family: 'Quicksand', sans-serif;
        font-weight: 700;
        font-size: 18px;
        color: #fff;
        line-height: 40px;
        text-align: center;
        background-color: #87314e;
        border: 1px #87314e solid;
        opacity: 1;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #df405a;
        border: 1px #df405a solid;
    }

    input[type=submit]:focus {
        outline: none;
    }

    p.field span.i {
        width: 24px;
        height: 24px;
        float: right;
        position: relative;
        margin-top: -26px;
        right: 2px;
        z-index: 2;
        display: none;

        -webkit-animation: bounceIn 0.6s linear;
        -moz-animation: bounceIn 0.6s linear;
        -o-animation: bounceIn 0.6s linear;
        animation: bounceIn 0.6s linear;
    }

    /*--------------------
Transitions
---------------------*/

    .box-form,
    .box-info,
    .b,
    .b-support,
    .b-cta,
    input[type=submit],
    p.field span.i {

        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        -ms-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }

    /*--------------------
Credits
---------------------*/

    .icon-credits {
        width: 100%;
        position: absolute;
        bottom: 4px;
        font-family: 'Open Sans', 'Helvetica Neue', Helvetica, sans-serif;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.1);
        text-align: center;
        z-index: -1;
    }

    .icon-credits a {
        text-decoration: none;
        color: rgba(255, 255, 255, 0.2);
    }
</style>

{{-- <div class="center-form">
	<form class="form_container"role="form" method="POST"action="{{ url('/auth/login') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	  <div class="logo_container"></div>
	  <div class="title_container">
		<p class="title">Login to your Account</p>
		<span class="subtitle">It will be enough to click on the button at the bottom to log into <b>GOLink</b> safely</span>
	  </div>
	  <br>
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
	  <div class="input_container">
		<label class="input_label" for="email_field">Email</label>
		<svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="icon">
		  <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
		  <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
		</svg>
		<input placeholder="" title="Inpit title" name="email" type="text" class="input_field" id="email_field" value="{{ old('email') }}" autofocus>
	  </div>
	  <div class="input_container">
		<label class="input_label" for="password_field">Password</label>
		<svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="icon">
		  <path stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M18 11.0041C17.4166 9.91704 16.273 9.15775 14.9519 9.0993C13.477 9.03404 11.9788 9 10.329 9C8.67911 9 7.18091 9.03404 5.70604 9.0993C3.95328 9.17685 2.51295 10.4881 2.27882 12.1618C2.12602 13.2541 2 14.3734 2 15.5134C2 16.6534 2.12602 17.7727 2.27882 18.865C2.51295 20.5387 3.95328 21.8499 5.70604 21.9275C6.42013 21.9591 7.26041 21.9834 8 22"></path>
		  <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M6 9V6.5C6 4.01472 8.01472 2 10.5 2C12.9853 2 15 4.01472 15 6.5V9"></path>
		  <path fill="#141B34" d="M21.2046 15.1045L20.6242 15.6956V15.6956L21.2046 15.1045ZM21.4196 16.4767C21.7461 16.7972 22.2706 16.7924 22.5911 16.466C22.9116 16.1395 22.9068 15.615 22.5804 15.2945L21.4196 16.4767ZM18.0228 15.1045L17.4424 14.5134V14.5134L18.0228 15.1045ZM18.2379 18.0387C18.5643 18.3593 19.0888 18.3545 19.4094 18.028C19.7299 17.7016 19.7251 17.1771 19.3987 16.8565L18.2379 18.0387ZM14.2603 20.7619C13.7039 21.3082 12.7957 21.3082 12.2394 20.7619L11.0786 21.9441C12.2794 23.1232 14.2202 23.1232 15.4211 21.9441L14.2603 20.7619ZM12.2394 20.7619C11.6914 20.2239 11.6914 19.358 12.2394 18.82L11.0786 17.6378C9.86927 18.8252 9.86927 20.7567 11.0786 21.9441L12.2394 20.7619ZM12.2394 18.82C12.7957 18.2737 13.7039 18.2737 14.2603 18.82L15.4211 17.6378C14.2202 16.4587 12.2794 16.4587 11.0786 17.6378L12.2394 18.82ZM14.2603 18.82C14.8082 19.358 14.8082 20.2239 14.2603 20.7619L15.4211 21.9441C16.6304 20.7567 16.6304 18.8252 15.4211 17.6378L14.2603 18.82ZM20.6242 15.6956L21.4196 16.4767L22.5804 15.2945L21.785 14.5134L20.6242 15.6956ZM15.4211 18.82L17.8078 16.4767L16.647 15.2944L14.2603 17.6377L15.4211 18.82ZM17.8078 16.4767L18.6032 15.6956L17.4424 14.5134L16.647 15.2945L17.8078 16.4767ZM16.647 16.4767L18.2379 18.0387L19.3987 16.8565L17.8078 15.2945L16.647 16.4767ZM21.785 14.5134C21.4266 14.1616 21.0998 13.8383 20.7993 13.6131C20.4791 13.3732 20.096 13.1716 19.6137 13.1716V14.8284C19.6145 14.8284 19.619 14.8273 19.6395 14.8357C19.6663 14.8466 19.7183 14.8735 19.806 14.9391C19.9969 15.0822 20.2326 15.3112 20.6242 15.6956L21.785 14.5134ZM18.6032 15.6956C18.9948 15.3112 19.2305 15.0822 19.4215 14.9391C19.5091 14.8735 19.5611 14.8466 19.5879 14.8357C19.6084 14.8273 19.6129 14.8284 19.6137 14.8284V13.1716C19.1314 13.1716 18.7483 13.3732 18.4281 13.6131C18.1276 13.8383 17.8008 14.1616 17.4424 14.5134L18.6032 15.6956Z"></path>
		</svg>
		<input placeholder="Password" title="Inpit title" name="password" type="password" class="input_field" id="password_field">
	  </div>
	  <button title="Sign In" type="submit" class="sign-in_btn">
		<span>Login</span>
	  </button>
	<div class="footer-section">

	  <p class="note" style="font-size: 15px; margin: 0;">
		Don't have an account? <a href="{{ url('auth/register') }}" class="signup-link">Sign Up</a>
	  </p>
	</div>
	
	</form>
	</div> --}}

<body>
    <div class='box'>
        <form class="form_container"role="form" method="POST"action="{{ url('/auth/login') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class='box-form'>
                <div class='box-login-tab'></div>
                <div class='box-login-title'>
                    <div class='i i-login'></div>
                    <h2>LOGIN</h2>
                </div>
                <div class='box-login'>
                    <div class='fieldset-body' id='login_form'>
                        <button onclick="openLoginInfo();" class='b b-form i i-more' title='Mais Informações'></button>
                        <p class='field'>
                            <label for='user'>E-MAIL</label>
                            <input title="Inpit title" name="email" type="text" class="input_field" id="email_field" value="{{ old('email') }}" autofocus />
                            <span id='valida' class='i i-warning'></span>
                        </p>
                        <p class='field' style="position: relative;">
                            <label for='pass'>PASSWORD</label>
                            <input placeholder="Password" title="Input title" name="password" type="password" 
                                   class="input_field" id="password_field" 
                                   style="width: 100%; padding-right: 35px;" oninput="keepEyeIcon()"/>
                            <span id='valida' class='i i-close'></span>
                            <span onclick="togglePassword()" 
                                  id="toggle_eye"
                                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <i id="eye_icon" class="fa fa-eye"></i>
                            </span>
                        </p>
                        <input type='submit' id='do_login' value='LOGIN' title='Login' />
						
                    </div>
                </div>
            </div>
            <div class='box-info'>
                <p><button onclick="closeLoginInfo();" class='b b-info i i-left' title='Back to Sign In'></button>
                <h3>Need Help?</h3>
                </p>
                <div class='line-wh'></div>
                <button onclick="" class='b-support' title='Forgot Password?'> Forgot Password?</button>
                <button onclick="" class='b-support' title='Contact Support'> Contact Support</button>
                <div class='line-wh'></div>
                <button onclick="" class='b-cta' title='Sign up now!'> <a href="{{ url('auth/register') }}" class="b-cta" title="Sign up now!">CREATE ACCOUNT</a></button>
            </div>
		</form>

    </div>


    <script>
function togglePassword() {
        var passwordField = document.getElementById("password_field");
        var eyeIcon = document.getElementById("eye_icon");
        var eyeContainer = document.getElementById("toggle_eye");
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }

        eyeContainer.style.display = "inline-block";
    }

    function keepEyeIcon() {
        var eyeContainer = document.getElementById("toggle_eye");
        eyeContainer.style.display = "inline-block";
    }
        $(document).ready(function() {
            $("#do_login").click(function() {
                closeLoginInfo();
                $(this).parent().find('span').css("display", "none");
                $(this).parent().find('span').removeClass("i-save i-warning i-close");

                var proceed = true;
                $("#login_form input").each(function() {
                    if (!$.trim($(this).val())) {
                        $(this).parent().find('span').addClass("i-warning");
                        $(this).parent().find('span').css("display", "block");
                        proceed = false;
                    }
                });

                if (proceed) {
                    $(this).parent().find('span').addClass("i-save");
                    $(this).parent().find('span').css("display", "block");
                }
            });

            $("#login_form input").keyup(function() {
                $(this).parent().find('span').css("display", "none");
            });

            openLoginInfo();
            setTimeout(closeLoginInfo, 1000);
        });

        function openLoginInfo() {
            $('.b-form').css("opacity", "0.01");
            $('.box-form').css("left", "-37%");
            $('.box-info').css("right", "-37%");
        }

        function closeLoginInfo() {
            $('.b-form').css("opacity", "1");
            $('.box-form').css("left", "0px");
            $('.box-info').css("right", "-5px");
        }

        $(window).on('resize', function() {
            closeLoginInfo();
        });
    </script>
</body>

</html>
