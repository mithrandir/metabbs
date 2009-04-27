<?php
$fonts = SimpleCaptcha::get_fonts();
$oVisualCaptcha = new PhpCaptcha($fonts, 120, 18);
$oVisualCaptcha->SetMinFontSize(12);
$oVisualCaptcha->SetMaxFontSize(15);
$oVisualCaptcha->Create();
?>
