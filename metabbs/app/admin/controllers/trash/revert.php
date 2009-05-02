<?php
TrashCan::revert($params['id']);
redirect_to(url_admin_for('trash'));
