<?php
/**
 * YetAnotherKeywords - A MediaWiki tag extension for adding <meta> keywords to a page.
 *
 * @file
 * @author Jehy
 * Based on plugin by Joshua C. Lerner
 * @copyright Copyright © 2008-2012 Jehy
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

class YetAnotherKeywords {
	/**
	 * Register the <metakeywords> tag with the parser.
	 *
	 * @param Parser $parser
	 */
	public static function onParserFirstCallInit( $parser ) {
		$parser->setHook( 'metakeywords', [ __CLASS__, 'render' ] );
	}

	/**
	 * Renders the <metakeywords> tag.
	 *
	 * @param string $text Incoming text - should always be null or empty (passed by value).
	 * @param array $params Attributes specified for tag - must contain 'content' (passed by value).
	 * @param Parser $parser Reference to currently running parser (passed by reference).
	 * @return string
	 */
	public static function render( $text, $params = [], $parser ) {
		// Short-circuit with error message if content is not specified.
		if ( !isset( $text ) ) {
			return
				'<div class="errorbox"&gt;'.
				wfMessage( 'YetAnotherKeywords-missing-content' )->inContentLanguage()->escaped().
				'</div&gt;';
		}

		return '<!-- META_KEYWORDS ' . base64_encode( $text ) . ' -->';
	}

	/**
	 * Adds the <meta> keywords to document head.
	 *
	 * @param OutputPage $out Handle to an OutputPage object
	 * @param string $text Output text
	 * @return bool Always true to allow other extensions to continue processing.
	 */
	public static function insertMetaKeywords( $out, $text ) {
		// Extract meta keywords
		if (
			preg_match_all(
				'/<!-- META_KEYWORDS ([0-9a-zA-Z\\+\\/]+=*) -->/m',
				$text,
				$matches
			) === false
		) {
			return true;
		}

		$data = $matches[1];
		// Merge keywords data into OutputPage as meta tag
		foreach ( $data as $item ) {
			$content = @base64_decode( $item );
			if ( $content ) {
				$out->addMeta( 'keywords', $content );
			}
		}

		return true;
	}

}
