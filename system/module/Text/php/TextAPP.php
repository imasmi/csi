<?php
namespace module\Text;

class TextAPP {

    public static function wysiwyg(){
        /* SELECTED CONTENT FOR WYSIWYG */

		echo '<input type="hidden" id="selected-content" value=""/>';

		$files_dir = \system\Core::url() . 'system/module/Text/files';

		/* WYSIWYG editor*/
		echo '<div id="wysiwyg" class="TextAPP" style="display: none;">
			<img src="' . $files_dir . '/undo.png" onclick="TextAPP.wysiwyg(\'undo\')" title="undo" alt="undo">
			<img src="' . $files_dir . '/redo.png" onclick="TextAPP.wysiwyg(\'redo\')" title="redo" alt="redo">
			<img src="' . $files_dir . '/link.png" onclick="TextAPP.wysiwyg(\'createLink\',prompt(\'URL?\'))" title="link" alt="link">
			<img src="' . $files_dir . '/unlink.png" onclick="TextAPP.wysiwyg(\'unlink\')" title="unlink" alt="unlink">
			<img src="' . $files_dir . '/h1.png" onclick="TextAPP.wysiwyg(\'formatBlock\', \'<h1>\')" title="h1" alt="h1" class="Htag">
			<img src="' . $files_dir . '/h2.png" onclick="TextAPP.wysiwyg(\'formatBlock\', \'<h2>\')" title="h2" alt="h2" class="Htag">
			<img src="' . $files_dir . '/h3.png" onclick="TextAPP.wysiwyg(\'formatBlock\', \'<h3>\')" title="h3" alt="h3" class="Htag">
			<img src="' . $files_dir . '/h4.png" onclick="TextAPP.wysiwyg(\'formatBlock\', \'<h4>\')" title="h4" alt="h4" class="Htag">
			<img src="' . $files_dir . '/h5.png" onclick="TextAPP.wysiwyg(\'formatBlock\', \'<h5>\')" title="h5" alt="h5" class="Htag">
			<img src="' . $files_dir . '/h6.png" onclick="TextAPP.wysiwyg(\'formatBlock\', \'<h6>\')" title="h6" alt="h6" class="Htag">
			<img src="' . $files_dir . '/paragraph.png" onclick="TextAPP.wysiwyg(\'insertparagraph\')" title="paragraph" alt="paragraph">
			<img src="' . $files_dir . '/indent.png" onclick="TextAPP.wysiwyg(\'indent\')" title="indent" alt="indent">
			<img src="' . $files_dir . '/outdent.png" onclick="TextAPP.wysiwyg(\'outdent\')" title="outdent" alt="outdent">
			<select onchange="TextAPP.changeFont(this.value)">';
    		    for($s = 8; $s < 100; ++$s){
    		        echo '<option value="' . $s . '">' . $s . '</option>';
    		    }
		    echo '</select>
			<img src="' . $files_dir . '/delete.png" onclick="TextAPP.wysiwyg(\'delete\')" title="delete" alt="delete">
			</br>

			<img src="' . $files_dir . '/bold.png" onclick="TextAPP.wysiwyg(\'bold\')" title="bold" alt="bold">
			<img src="' . $files_dir . '/italic.png" onclick="TextAPP.wysiwyg(\'italic\')" title="italic" alt="italic">
			<img src="' . $files_dir . '/underline.png" onclick="TextAPP.wysiwyg(\'underline\')" title="underline" alt="underline">
			<img src="' . $files_dir . '/strikethrough.png" onclick="TextAPP.wysiwyg(\'strikethrough\')" title="strikethrough"
alt="strikethrough">
			' . static::color_picker('backcolor', 'wysiwyg') . '
			' . static::color_picker('forecolor', 'wysiwyg') . '
			<img src="' . $files_dir . '/al.png" onclick="TextAPP.wysiwyg(\'justifyleft\')" title="left" alt="left">
			<img src="' . $files_dir . '/ar.png" onclick="TextAPP.wysiwyg(\'justifyright\')" title="right" alt="right">
			<img src="' . $files_dir . '/ac.png" onclick="TextAPP.wysiwyg(\'justifycenter\')" title="center" alt="center">
			<img src="' . $files_dir . '/justify.png" onclick="TextAPP.wysiwyg(\'justifyfull\')" title="justify" alt="justify">
			<img src="' . $files_dir . '/ol.png" onclick="TextAPP.wysiwyg(\'insertorderedlist\')" title="ol" alt="ol">
			<img src="' . $files_dir . '/ul.png" onclick="TextAPP.wysiwyg(\'insertunorderedlist\')" title="ul" alt="ul">
			<img src="' . $files_dir . '/hr.png" onclick="TextAPP.wysiwyg(\'inserthorizontalrule\')" title="hr" alt="hr">
			<select onchange="TextAPP.wysiwyg(\'fontname\', this.value)">
				<option style="font-family:Arial;">Arial</option>
				<option style="font-family:Comic Sans MS;">Comic Sans MS</option>
				<option style="font-family:Courier New;">Courier New</option>
				<option style="font-family:Georgia;">Georgia</option>
				<option style="font-family:Impact;">Impact</option>
				<option style="font-family:Times New Roman;">Times New Roman</option>
				<option style="font-family:Tahoma;">Tahoma</option>
				<option style="font-family:Verdana;" value="Verdana">Verdana</option>
			</select>
		</div>';
    }

    /* COLOR PICKER */
	private static function color_picker($id, $type, $value = ""){
		$cnt = 1;
		$files_dir = \system\Core::url() . 'system/module/Text/files';
		$output = '<div class="color-wrapper">';
		if($type == "wysiwyg"){
			$output .= '<img src="' . $files_dir . '/' . $id . '.png" title="' . $value . '" alt="' . $value . '" onclick="S.show(\'#color-picker-' . $id . '\'); S.event(S(\'#color-selector-' . $id . '\'), \'mousedown\')">' ;
		} else {
			$output .= '<div id="settings-color' . $id . '" class="settings-color" style="background-color: ' . $value . ';" onclick="TextAPP.colorSelector(\'' . $id . '\')"></div>';
			$output .= '<input type="hidden" name="' . $id . '" id="color-val-' . $id . '" value="' . $value . '"/>';
		}
		
		$output .= '<div class="color-picker white-bg" id="color-picker-' . $id . '">';
		    $output .= '<input value="000000" class="color-selector"  id="color-selector-' . $id . '" data-jscolor="{}" onchange="TextAPP.wysiwyg(\'' . $id . '\', this.value)">';
		    $output .= '<span onclick="S.hide(\'#color-picker-' . $id . '\')" class="pointer">X</span>';
		$output .= '</div>';
		
		/*
		$output .= '<table class="color-picker set-table" id="color-selector-' . $id . '" cellspacing="0px" border="0px">';
			$output .= '<tr>';
				$output .= '<th colspan="34">Choose color</th>';
				$output .= '<th colspan="2" onclick="S.hide(\'#color-selector-' . $id . '\')" class="hideColors">X</th>';
			$output .= '</tr>';
			$output .= '<tr>';
			for ($red=1; $red<=255; $red+=51) {
  			for ($green=1; $green<=255; $green+=51){
     			for ($blue=1; $blue<=255; $blue+=51){
      				$color =  "#".str_pad(dechex($red), 2, "0", STR_PAD_LEFT)  .str_pad(dechex($green), 2, "0", STR_PAD_LEFT)  .str_pad(dechex($blue), 2, "0", STR_PAD_LEFT);
				$output .= '<td>';
					$output .= '<input type="button" class="colorField" onclick="TextAPP.selectColor(\'' . $id . '\', \'' . $cnt . '\', \'' . $type . '\')" style="background-color: ' . $color . ';"/>';
					$output .= '<input type="hidden" value="' . $color . '" id="colorField' . $cnt .'">';
				$output .= '</td>';
				if(is_int($cnt/36)){ $output .= '</tr><tr>';}
				$cnt++;
			}
 			}
			}
		$output .= '</table>';
		*/
		$output .= '</div>';
		return $output;
	}

	//array possible values:
    //start => int,
    //length => int,
    //search => string (if set start point is the start of the first founded occurence of the needle)
    public static function slice($text, $array=array()){
        $start = isset($array["start"]) ? $array["start"] : 0;
        $words = explode(" ", $text);

        if(isset($array["search"])){
            foreach($words as $wordKey => $wordValue){
                if(!empty($wordValue) && isset($array["search"]) && strpos(mb_strtolower($wordValue, "UTF-8"), mb_strtolower($array["search"], "UTF-8")) !== false){
                    $words[$wordKey] = '<span class="listing-highlight">' . $wordValue . '</span>';
                    $start = $wordKey + $start >= 0 ? $wordKey + $start : 0;
                    break;
                }
            }
        }

        $length = isset($array["length"]) ? $start + $array["length"] : $start + 15;
        $slice = array_slice($words, $start, $array["length"]);
        $colon = count($words) > $length ? " ..." : "";
        return implode(" ", $slice) . $colon;
    }
}
?>
