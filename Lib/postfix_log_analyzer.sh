#!/bin/bash
#umask 002
#sudo chmod 777 /var/log/mail.log
sudo -u root perl pflogsumm.pl -e -d yesterday --problems_first /var/log/mail.log | mail -s "Mail activity for yesterday" $1
#sudo chmod 640 /var/log/mail.log
echo "script complete"
