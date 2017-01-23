<?php
/**
 * 返回可读性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

/**
 * 返回cheked状态
 * @param $value
 * @return string
 */
function checked($value)
{
    return $value ? 'checked' : '';
}


//上传图片的完整路径
function page_image($value = null)
{
    if(empty($value)){
        $value = config('blog.page_image');
    }

    if(! starts_with($value,'http') && $value[0] !='/'){
        $value = config('blog.uploads.webpath').'/'.$value;
    }

    return $value;
}