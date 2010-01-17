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


$wgExtensionCredits['parserhook'][] = array(
  'name' => 'Amazon Widget',
  'author' => 'Glen E. Ivey',
  'url' => 'http://github.com/gleneivey/AmazonWidget',
  'version' => '0.1',
  'description' => "Place an Amazon Associates advertising Widget " .
    "into the wiki page at the tag's location."
);


if (defined('MW_SUPPORTS_PARSERFIRSTCALLINIT'))
  $wgHooks['ParserFirstCallInit'][] = 'AmazonWidget::setup';
else
  $wgExtensionFunctions[] = 'AmazonWidget::setup';

$wgAutoloadClasses['AmazonWidget'] =
  dirname( __FILE__) . "/AmazonWidget_body.php";

