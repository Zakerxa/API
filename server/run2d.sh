#!/bin/bash
#!/usr/bin/php
export TZ=Asia/Yangon
date=$(date +%a)
i=0
fireup()
  {  
    while [ "true" ]; do
      currenttime=$(date +%H:%M)
      currentHour=$(date +%H)
      currentMin=$(date +%M)
      currentSec=$(date +%S)
      currentTime=$(date +%H:%M:%S)
      if [[ "$currenttime" > "09:29" ]] && [[ "$currenttime" < "10:59" ]] && [[ "$date" != "Sat" ]] && [[ "$date" != "Sun" ]]; then
         /usr/local/bin/php /home/cp285633/public_html/API/server/2dApi.php
        ((i++))
        echo "Sleeping 22 First Loop: $i"
          if [[ $i == 120 ]] || [[ "$currenttime" == "09:59" ]] || [[ "$currenttime" == "10:28" ]] || [[ "$currenttime" == "10:58" ]]; then
          break
          fi
        sleep 16
      elif [[ "$currenttime" > "10:59" ]] && [[ "$currenttime" < "11:29" ]] && [[ "$date" != "Sat" ]] && [[ "$date" != "Sun" ]]; then
        /usr/local/bin/php /home/cp285633/public_html/API/server/2dApi.php
        ((i++))
          if [[ $i == 130 ]] || [[ "$currenttime" == "11:28" ]]; then
          break
          fi
        sleep 14
      elif [[ "$currenttime" > "11:29" ]] && [[ "$currenttime" < "12:03" ]] && [[ "$date" != "Sat" ]] && [[ "$date" != "Sun" ]]; then
        /usr/local/bin/php /home/cp285633/public_html/API/server/2dApi.php
        ((i++))
          if (("$currentHour" == "11")) && (("$currentMin" <= "45")); then
            sleep 12
          elif (("$currentHour" == "11")) && (("$currentMin" > "45")) && (("$currentMin" <= "59")); then
            if (("$currentMin" == "59")) && (("$currentSec" >= "45")); then
              break
            fi
            sleep 10
          elif (("$currentHour" == "12")) && (("$currentMin" <= "01")); then
            sleep 8
          elif (("$currentHour" == "12")) && (("$currentMin" > "01")); then
            break
          fi
        
      elif [[ "$currenttime" > "14:29" ]] && [[ "$currenttime" < "16:00" ]] && [[ "$date" != "Sat" ]] && [[ "$date" != "Sun" ]]; then
        /usr/local/bin/php /home/cp285633/public_html/API/server/2dApi.php
        if (( "$currentHour" == "14" )); then
            if [[ "$currenttime" == "14:59" ]]; then
              break
            fi
            sleep 16
        elif (("$currentHour" == "15")); then
            echo "15H"
            if (("$currentMin" <= "28")); then
              sleep 14
            elif (("$currentMin" == "29"));then
              break
            elif (("$currentMin" > "29")) && (("$currentMin" <= "58")); then
              sleep 12
            elif (("$currentMin" == "59")); then
              if (("$currentSec" <= "48")); then
                sleep 12
              else
                break
              fi
            fi
        fi
      elif [[ "$currenttime" > "15:59" ]] && [[ "$currenttime" < "16:33" ]] && [[ "$date" != "Sat" ]] && [[ "$date" != "Sun" ]]; then
        /usr/local/bin/php /home/cp285633/public_html/API/server/2dApi.php
        ((i++))
          if [[ $i == 190 ]] || [[ "$currenttime" == "16:32" ]]; then
          break
          fi
        sleep 10
      else
        echo $currentTime
        break
      fi
    done
    echo "End"
  }

fireup