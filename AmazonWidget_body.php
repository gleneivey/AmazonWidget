<?

# Amazon Widget -- a MediaWiki tag extension for placing Amazon Associates
#                  advertising Widgets in wiki pages
# Copyright (C) 2010 - Glen E. Ivey
#     http://github.com/gleneivey/AmazonWidget
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License version
# 3 as published by the Free Software Foundation.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program in the file COPYING and/or LICENSE.  If not,
# see <http://www.gnu.org/licenses/>.


class AmazonWidget {
  const NAME = "amazonwidget";

  static function setup(){
    global $wgParser;
    $wgParser->setHook(self::NAME, array('AmazonWidget', 'render'));
    return true;
  }

  static function render( $input, $argv, &$parser ){
    global $wg_AMZWID_associateId;
    global $wg_AMZWID_urlTemplate;
    global $wg_AMZWID_noScriptTemplate;
    global $wg_AMZWID_margin;


    // error check input; no HTML injection from wiki text
    $adCode = $argv['adcode'];
    if ( preg_match( "/^[0-9a-fA-F-]+$/", $adCode ) == 0 )
      return "\n<!-- AmazonWidget: got bad 'adcode' attribute -->\n";

    // apply defaults
    if ($wg_AMZWID_urlTemplate)
      $url = $wg_AMZWID_urlTemplate;
    else
      $url = "http://ws.amazon.com/widgets/q?ServiceVersion=20070822&MarketPlace=US&ID=V20070822/US/$1/8001/$2";

    if ($wg_AMZWID_noScriptTemplate)
      $noScript = $wg_AMZWID_noScriptTemplate;
    else
      $noScript = "&Operation=NoScript";

    $float = 'right';
    $margin = 'left';
    if ( $argv['float'] ){
      if ( preg_match( "/^left$/i", $argv['float'] ) ){
        $float = 'left';
        $margin = 'right';
      }
      else if ( preg_match( "/^right$/i", $argv['float'] ) ){
        $float = 'right';
        $margin = 'left';
      }
      else if ( preg_match( "/^none$/i", $argv['float'] ) ){
        $float = 'none';
        $wg_AMZWID_margin = '';
      }
    }

    // compose widget URL
    $url = str_replace( '$1', $wg_AMZWID_associateId, $url );
    $url = str_replace( '$2', $adCode, $url );

    // compose HTML script/noscript tags
    $htmlOut  = '<div class="AmazonWidget" ';
    $htmlOut .= 'id="' . $adCode . '" ';
    $htmlOut .= 'style="float: ' . $float;
    if ( $wg_AMZWID_margin && ($wg_AMZWID_margin != '') )
      $htmlOut .= '; margin-' . $margin . ': ' . $wg_AMZWID_margin . ';';
    $htmlOut .= '">';
    $htmlOut .= '<script charset="utf-8" type="text/javascript" src="';
    $htmlOut .= $url;
    $htmlOut .= '"></script> <noscript><a href="';
    $htmlOut .= $url . $noScript;
    $htmlOut .= '">Amazon.com Widgets</a></noscript>';
    $htmlOut .= "</div>";

    return $htmlOut;
  }
}

