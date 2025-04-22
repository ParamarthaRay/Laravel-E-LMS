
@ECHO OFF 
SETLOCAL
SETLOCAL ENABLEDELAYEDEXPANSION
if exist "C:\Program Files\Microsoft\Microsoft Ajax Minifier\AjaxMin.exe" (
 set PPATH="C:\Program Files\Microsoft\Microsoft Ajax Minifier\AjaxMin.exe"
) else (
 set PPATH="C:\Program Files (x86)\Microsoft\Microsoft Ajax Minifier\AjaxMin.exe"
) 

if exist  "C:\Program Files(x86)\Microsoft\Microsoft Ajax Minifier\AjaxMin.exe" (
 set PPATH="C:\Program Files(x86)\Microsoft\Microsoft Ajax Minifier\AjaxMin.exe"
)

:: js
for /r %%f  in (*.js) do (
			
	echo.%%~nf | findstr /C:min 1>nul	
	
	if errorlevel 1 (
	  %PPATH% %%f -o %%~nf.min.js
	  echo. -------------------------------------------------------------------
	)
)

:: css
for /r %%f  in (*.css) do (
	
	echo.%%~nf | findstr /C:min 1>nul	
	
	if errorlevel 1 (
	  %PPATH% %%f -o %%~nf.min.css
	  echo. -------------------------------------------------------------------
	)
)



if exist %PPATH% ECHO. All files has been minified.. :)
ECHO. Press any key...
pause > nul