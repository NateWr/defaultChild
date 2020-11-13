<?php

/**
 * @defgroup plugins_themes_default_child Default theme plugin
 */

/**
 * @file plugins/themes/defaultChild/index.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_themes_defaultChild
 * @brief Wrapper for default child theme plugin.
 *
 */

require_once('DefaultChildThemePlugin.inc.php');

return new DefaultChildThemePlugin();

?>
