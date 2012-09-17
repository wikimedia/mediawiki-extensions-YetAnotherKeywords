<?php
/*
 * YetAnotherKeywords.php - A MediaWiki tag extension for adding <meta> keywords to a page.
 * @author Jehy
 * Based on plugin by Joshua C. Lerner
 * @version 0.2
 * @copyright Copyright (C) 2008-2012 Jehy
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php
 * -----------------------------------------------------------------------
 * Description:
 *     This is a MediaWiki extension which adds support for injecting a <meta> keywords tag
 *     into the page header.
 * Requirements:
 *     MediaWiki 1.6.x, 1.8.x, 1.9.x, ... , 1.19 or higher
 *     PHP 4.x, 5.x or higher
  * Installation:
 *     1. Drop this script (YetAnotherKeywords.php) in $IP/extensions
 *         Note: $IP is your MediaWiki install dir.
 *     2. Enable the extension by adding this line to your LocalSettings.php:
 *         require_once('extensions/YetAnotherKeywords.php');
 * Usage:
 *     Once installed, you may utilize YetAnotherKeywords by adding the <metakeywords> tag to articles:
 *         <metakeywords> Home page for the YetAnotherKeywords MediaWiki extension </metakeywords>
 * Version Notes:
 *     version 0.2
 * -----------------------------------------------------------------------
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 * -----------------------------------------------------------------------
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

# Credits
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'YetAnotherKeywords',
	'author' => 'Jehy http://jehy.ru/index.en.html',
	'url' => 'http://jehy.ru/wiki-extensions.en.html',
	'description' => 'Adds &lt;metakeywords&gt; tag to inject meta keywords into page header.',
	'version'=> '0.2'
);

$wgExtensionFunctions[] = 'setupYetAnotherKeywordsParserHooks';

/**
 * Sets up the YetAnotherKeywords Parser hook and system messages
 */
function setupYetAnotherKeywordsParserHooks() {
	global $wgParser, $wgMessageCache;
	$wgParser->setHook( 'metakeywords', 'renderYetAnotherKeywords' );
	/*$wgMessageCache->addMessage(
		'YetAnotherKeywords-missing-content',
		'Error: &lt;metakeywn&gt; tag must contain a &quot;content&quot; attribute.'
	);*/
}

/**
 * Renders the <metakeywords> tag.
 * @param String $text Incoming text - should always be null or empty (passed by value).
 * @param Array $params Attributes specified for tag - must contain 'content' (passed by value).
 * @param Parser $parser Reference to currently running parser (passed by reference).
 * @return String Always empty.
 */
function renderYetAnotherKeywords( $text, $params = array(), $parser ) {

	// Short-circuit with error message if content is not specified.
	if ( !isset($text) ) {
		return
			'<div class="errorbox"&gt;'.
			wfMsgForContent('YetAnotherKeywords-missing-content').
			'</div&gt;';
	}

	return '<!-- META_KEYWORDS '.base64_encode($text).' -->';
}

// Attach post-parser hook to extract metadata and alter headers
$wgHooks['OutputPageBeforeHTML'][] = 'insertMetaKeywords';

/**
 * Adds the <meta> keywords to document head.
 * Usage: $wgHooks['OutputPageBeforeHTML'][] = 'insertMetaKeywords';
 * @param OutputPage $out Handle to an OutputPage object - presumably $wgOut (passed by reference).
 * @param String $text Output text.
 * @return Boolean Always true to allow other extensions to continue processing.
 */
function insertMetaKeywords( $out, $text ) {

	// Extract meta keywords
	if (preg_match_all(
		'/<!-- META_KEYWORDS ([0-9a-zA-Z\\+\\/]+=*) -->/m',
		$text,
		$matches)===false
	) return true;
	$data = $matches[1];
	// Merge keywords data into OutputPage as meta tag
	foreach ($data AS $item) {
		$content = @base64_decode($item);
		if ($content)
			$out->addMeta( 'keywords', $content );
	}
	return true;
}
?>