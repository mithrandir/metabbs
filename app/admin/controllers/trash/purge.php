<?php
TrashCan::purge($params['id']);
redirect_to(url_admin_for('trash'));
