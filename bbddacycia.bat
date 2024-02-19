echo on
Q:
cd \b_sisadge\bbdd/
mysqldump  -hlocalhost --password=ac2006 --user=acycia_root acycia_intranet > acycia_intranet_%time:~0,2%.sql