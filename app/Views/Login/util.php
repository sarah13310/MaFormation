<?php

function createOptionType($select=0)
{
    $types = ["Vous êtes", "Formateur", "Entreprise","Particulier" ];
    $selected_index=array_search($select,$types);
    $options = "";
    $index = 1;
    foreach ($types as $type) {
        $selected=($index == $selected_index)?"selected":"";
        $options .= "<option value='$index' $selected >$type</option>";
        $index++;
    }
    return $options;
}
