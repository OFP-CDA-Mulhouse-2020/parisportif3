CREATE DATABASE IF NOT EXISTS `pari_sportif_db_test`;
CREATE DATABASE IF NOT EXISTS `pari_sportif_db_prod`;

GRANT ALL PRIVILEGES ON `pari_sportif_db_test`.* TO pari_user;
GRANT ALL PRIVILEGES ON `pari_sportif_db_prod`.* TO pari_user;
