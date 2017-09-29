<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'neotropiclab');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '8mZEh*Q5fz5E_>Fg/NY_@Jm`UL<!xT,A6,zM)*(G8W4mZ3Vv`X)sZ|ghI,*}_wbt');
define('SECURE_AUTH_KEY',  '^b2?oSoo_@Wts?/jE9Jqs3?E]5TeF~a5dR+#%p}3,F1t9QWG_hf r?&~[zZ2#@![');
define('LOGGED_IN_KEY',    'W+{a/;ob%kYF;I4H[SrIJ#{*vI<!%NnJtG>?FI~r?+]`5tVp]28e7$p]MT@t*dbr');
define('NONCE_KEY',        '~F|dJQU~Rd>ail4)]rlPmV/}$]si`f|^sCZIwOqth?fDM>=9%-!9d]0vX$~yH}Jt');
define('AUTH_SALT',        '5@pD^LMSq..r~X]?eCy*#pecYoD/+sH&9-.%TGl/hQD>sa;CulG4(El+j%XGGyi9');
define('SECURE_AUTH_SALT', 'DaW/K>dQ(?IK{d.BXhGIQv7qAp%j%TX-ycF=9pbxTf[RvoN,,2l}uCw-OM=4V<pS');
define('LOGGED_IN_SALT',   ' Om:WFPZ8NIPXAHn3*w#m/s<S!C)svECTB=Lzssj6K*Um9>z0;4[DQUNt;cAP)M`');
define('NONCE_SALT',       'YX|;pGvv`1Ast5X<gMmoH~A6jz j4yAwU]m{ih-36=VB{pAkhhc=+N.CnG<u`v6b');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'neotlwp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
