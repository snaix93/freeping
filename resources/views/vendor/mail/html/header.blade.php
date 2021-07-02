<?php
switch ($level ?? '') {
    case 'recovery':
        $colorHex = '#06b25c';
        $headerTitle = '✅ Recovered!';
        break;
    case 'report':
        $colorHex = '#1f74ba';
        $headerTitle = '📝 Daily Report!';
        break;
    case 'alert':
        $colorHex = '#f95551';
        $headerTitle = '💥 Alert!';
        break;
    case 'warning':
        $colorHex = '#f39c3a';
        $headerTitle = '⚠️ Warning!';
        break;
    default:
        $colorHex = '#1f74ba';
        $headerTitle = '👋';
}
?>
<tr>
<td class="header" width="100%" style="background-color: {{ $colorHex }};">
<table class="inner-header" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="header-cell">
<a href="{{ $url }}" style="display: inline-block;">
<a href="{{ $url }}" target="_blank">
<img src="{{ asset('/images/emails/freeping-logo-white.png') }}" alt="FreePing.io"
style="border: 0; line-height: 100%; max-width: 100%; vertical-align: middle; font-size: 18px; color: #ffffff; width: 18rem;">
</a>
</a>
</td>
</tr>
<tr>
<td>
<table class="sub-header" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="header-cell">
<h1 style="font-weight: 400; text-align: center; font-size: 40px; margin: 0;">{{ $headerTitle ?? '' }}</h1>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
