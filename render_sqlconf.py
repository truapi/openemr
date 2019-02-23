import os
from jinja2 import Environment, FileSystemLoader

pwd = os.path.dirname(os.path.abspath(__file__))

def render_template():
  env = Environment(loader=FileSystemLoader(pwd), trim_blocks=True)
  print env.get_template('sqlconf.php.j2').render(
    mysql_host=os.environ['MYSQL_HOST'],
    mysql_port=os.environ['MYSQL_PORT'],
    mysql_user=os.environ['MYSQL_USER'],
    mysql_pass=os.environ['MYSQL_PASS'],
    mysql_database=os.environ['MYSQL_DATABASE']
  )

if __name__ == '__main__':
  render_template()
