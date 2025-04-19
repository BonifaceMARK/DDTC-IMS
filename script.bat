@echo off
set HOSTS=%SystemRoot%\System32\drivers\etc\hosts
findstr /C:"192.168.1.10 ddtc-ims.com" %HOSTS% >nul
if %errorlevel%==1 (
    echo 192.168.1.10 ddtc-ims.com >> %HOSTS%
    echo Added to hosts file.
) else (
    echo Entry already exists.
)
pause
