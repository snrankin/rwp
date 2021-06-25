<?php

namespace RWP\Vendor\tubalmartin\CssMin;

class Colors
{
    public static function getHexToNamedMap()
    {
        // Hex colors longer than named counterpart
        return array('#f0ffff' => 'azure', '#f5f5dc' => 'beige', '#ffe4c4' => 'bisque', '#a52a2a' => 'brown', '#ff7f50' => 'coral', '#ffd700' => 'gold', '#808080' => 'gray', '#008000' => 'green', '#4b0082' => 'indigo', '#fffff0' => 'ivory', '#f0e68c' => 'khaki', '#faf0e6' => 'linen', '#800000' => 'maroon', '#000080' => 'navy', '#fdf5e6' => 'oldlace', '#808000' => 'olive', '#ffa500' => 'orange', '#da70d6' => 'orchid', '#cd853f' => 'peru', '#ffc0cb' => 'pink', '#dda0dd' => 'plum', '#800080' => 'purple', '#f00' => 'red', '#fa8072' => 'salmon', '#a0522d' => 'sienna', '#c0c0c0' => 'silver', '#fffafa' => 'snow', '#d2b48c' => 'tan', '#008080' => 'teal', '#ff6347' => 'tomato', '#ee82ee' => 'violet', '#f5deb3' => 'wheat');
    }
    public static function getNamedToHexMap()
    {
        // Named colors longer than hex counterpart
        return array('aliceblue' => '#f0f8ff', 'antiquewhite' => '#faebd7', 'aquamarine' => '#7fffd4', 'black' => '#000', 'blanchedalmond' => '#ffebcd', 'blueviolet' => '#8a2be2', 'burlywood' => '#deb887', 'cadetblue' => '#5f9ea0', 'chartreuse' => '#7fff00', 'chocolate' => '#d2691e', 'cornflowerblue' => '#6495ed', 'cornsilk' => '#fff8dc', 'darkblue' => '#00008b', 'darkcyan' => '#008b8b', 'darkgoldenrod' => '#b8860b', 'darkgray' => '#a9a9a9', 'darkgreen' => '#006400', 'darkgrey' => '#a9a9a9', 'darkkhaki' => '#bdb76b', 'darkmagenta' => '#8b008b', 'darkolivegreen' => '#556b2f', 'darkorange' => '#ff8c00', 'darkorchid' => '#9932cc', 'darksalmon' => '#e9967a', 'darkseagreen' => '#8fbc8f', 'darkslateblue' => '#483d8b', 'darkslategray' => '#2f4f4f', 'darkslategrey' => '#2f4f4f', 'darkturquoise' => '#00ced1', 'darkviolet' => '#9400d3', 'deeppink' => '#ff1493', 'deepskyblue' => '#00bfff', 'dodgerblue' => '#1e90ff', 'firebrick' => '#b22222', 'floralwhite' => '#fffaf0', 'forestgreen' => '#228b22', 'fuchsia' => '#f0f', 'gainsboro' => '#dcdcdc', 'ghostwhite' => '#f8f8ff', 'goldenrod' => '#daa520', 'greenyellow' => '#adff2f', 'honeydew' => '#f0fff0', 'indianred' => '#cd5c5c', 'lavender' => '#e6e6fa', 'lavenderblush' => '#fff0f5', 'lawngreen' => '#7cfc00', 'lemonchiffon' => '#fffacd', 'lightblue' => '#add8e6', 'lightcoral' => '#f08080', 'lightcyan' => '#e0ffff', 'lightgoldenrodyellow' => '#fafad2', 'lightgray' => '#d3d3d3', 'lightgreen' => '#90ee90', 'lightgrey' => '#d3d3d3', 'lightpink' => '#ffb6c1', 'lightsalmon' => '#ffa07a', 'lightseagreen' => '#20b2aa', 'lightskyblue' => '#87cefa', 'lightslategray' => '#778899', 'lightslategrey' => '#778899', 'lightsteelblue' => '#b0c4de', 'lightyellow' => '#ffffe0', 'limegreen' => '#32cd32', 'mediumaquamarine' => '#66cdaa', 'mediumblue' => '#0000cd', 'mediumorchid' => '#ba55d3', 'mediumpurple' => '#9370db', 'mediumseagreen' => '#3cb371', 'mediumslateblue' => '#7b68ee', 'mediumspringgreen' => '#00fa9a', 'mediumturquoise' => '#48d1cc', 'mediumvioletred' => '#c71585', 'midnightblue' => '#191970', 'mintcream' => '#f5fffa', 'mistyrose' => '#ffe4e1', 'moccasin' => '#ffe4b5', 'navajowhite' => '#ffdead', 'olivedrab' => '#6b8e23', 'orangered' => '#ff4500', 'palegoldenrod' => '#eee8aa', 'palegreen' => '#98fb98', 'paleturquoise' => '#afeeee', 'palevioletred' => '#db7093', 'papayawhip' => '#ffefd5', 'peachpuff' => '#ffdab9', 'powderblue' => '#b0e0e6', 'rebeccapurple' => '#663399', 'rosybrown' => '#bc8f8f', 'royalblue' => '#4169e1', 'saddlebrown' => '#8b4513', 'sandybrown' => '#f4a460', 'seagreen' => '#2e8b57', 'seashell' => '#fff5ee', 'slateblue' => '#6a5acd', 'slategray' => '#708090', 'slategrey' => '#708090', 'springgreen' => '#00ff7f', 'steelblue' => '#4682b4', 'turquoise' => '#40e0d0', 'white' => '#fff', 'whitesmoke' => '#f5f5f5', 'yellow' => '#ff0', 'yellowgreen' => '#9acd32');
    }
}
