FROM openemr/openemr:5.0.1

RUN apk update && apk add py2-jinja2

COPY --chown=apache:root . /var/www/localhost/htdocs/openemr/

CMD python ./render_sqlconf.py > /var/www/localhost/htdocs/openemr/sites/default/sqlconf.php \
  && chown apache:root /var/www/localhost/htdocs/openemr/sites/default/sqlconf.php \
  && ./run_openemr.sh
