<?php
/**
 * NMarkdown class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * NMarkdown extends CMarkdown but adds in a few extras intot the markdown parser!
 *
 *
 * @author steve
 */
class NMarkdown extends CMarkdown
{
    public function transform($output) {
		// Add newlines as <br/> tags
		$output = preg_replace('/(?<!\n)\n(?![\n\*\#\-])/', "  \n", $output);
		// regex pattern to match urls
		/**
		 * (?xi)
		 * \b
		 * (                           # Capture 1: entire matched URL
		 *   (?:
		 * 	[a-z][\w-]+:                # URL protocol and colon
		 * 	(?:
		 * 	  /{1,3}                        # 1-3 slashes
		 * 	  |                             #   or
		 * 	  [a-z0-9%]                     # Single letter or digit or '%'
		 * 									# (Trying not to match e.g. "URI::Escape")
		 * 	)
		 * 	|                           #   or
		 * 	www\d{0,3}[.]               # "www.", "www1.", "www2." … "www999."
		 * 	|                           #   or
		 * 	[a-z0-9.\-]+[.][a-z]{2,4}/  # looks like domain name followed by a slash
		 *   )
		 *   (?:                           # One or more:
		 * 	[^\s()<>]+                      # Run of non-space, non-()<>
		 * 	|                               #   or
		 * 	\(([^\s()<>]+|(\([^\s()<>]+\)))*\)  # balanced parens, up to 2 levels
		 *   )+
		 *   (?:                           # End with:
		 * 	\(([^\s()<>]+|(\([^\s()<>]+\)))*\)  # balanced parens, up to 2 levels
		 * 	|                                   #   or
		 * 	[^\s`!()\[\]{};:'".,<>?«»“”‘’]        # not a space or one of these punct chars
		 *   )
		 * )
		 */
$patrn = <<<PATTERN
(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))
PATTERN;
		
		$output = preg_replace("@$patrn@", '<a href="$0" traget="_blank">$0</a>', $output);
	//	dp($match);
		return parent::transform($output);
	}
}