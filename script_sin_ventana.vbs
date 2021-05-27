Set WshShell = CreateObject("WScript.Shell") 
WshShell.Run chr(34) & "C:\Users\Felipe\Documents\Arduino\letras_led\ejecutar_script.bat" & Chr(34), 0
Set WshShell = Nothing