<?php
/*
 * YetAnotherKeywords.php - A MediaWiki tag extension for adding <meta> keywords to a page.
 * @author Jehy
 * Based on plugin by Joshua C. Lerner
 * @copyright Copyright (C) 2008-2012 Jehy
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php
 * -----------------------------------------------------------------------
 * Description:
 *     This is a MediaWiki extension which adds support for injecting a <meta> keywords tag
 *     into the page header.
 * Usage:
 *     Once installed, you may utilize YetAnotherKeywords by adding the <metakeywords> tag to articles:
 *         <metakeywords> Home page for the YetAnotherKeywords MediaWiki extension </metakeywords>
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

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'YetAnotherKeywords' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$GLOBALS['wgMessagesDirs']['YetAnotherKeywords'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for YetAnotherKeywords extension.' .
		'Please use wfLoadExtension instead,' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the YetAnotherKeywords extension requires MediaWiki 1.29+' );
}
