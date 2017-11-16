<?php

if (isset($_POST['rice']) && isset($_POST['misoshiru'])) {

    // data['rice'] と data['misoshiru'] が両方とも入っていた場合
    // 実際はここで $_POSTの中の値をデータベースにぶちこめばいいよね。
    echo "成功！ヾ( ﾟдﾟ)人( ﾟдﾟ)ﾉﾞ";

} else if(isset($_POST['rice'])) {

    // data['rice'] だけの場合
    echo "味噌汁が足りません(´・д・`  )";

} else if(isset($_POST['misoshiru'])) {

    // data['misoshiru'] だけの場合
    echo "ご飯がないです(´・д・`  )";

} else {

    // 何もない場合
    echo "ご飯も味噌汁もないです(；△；)";
}
