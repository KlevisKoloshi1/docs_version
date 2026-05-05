<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Shared</title>
</head>
<body style="margin:0;padding:24px;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="padding:20px 24px;background:#eff6ff;border-bottom:1px solid #dbeafe;">
                            <h1 style="margin:0;font-size:20px;line-height:1.3;color:#1d4ed8;">DocuCloud</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 12px;font-size:15px;line-height:1.6;">
                                <strong>{{ $sharedBy->name }}</strong> ({{ $sharedBy->email }}) shared a document with you.
                            </p>
                            <p style="margin:0 0 8px;font-size:14px;color:#4b5563;">
                                <strong>Document:</strong> {{ $document->title }}
                            </p>
                            <p style="margin:0 0 20px;font-size:14px;color:#4b5563;">
                                <strong>Permission:</strong> {{ strtoupper($permission) }}
                            </p>

                            <a href="{{ $documentUrl }}" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:10px 16px;border-radius:8px;font-weight:600;font-size:14px;">
                                Open Document
                            </a>

                            <p style="margin:20px 0 0;font-size:12px;color:#6b7280;">
                                If the button does not work, copy and paste this URL into your browser:<br>
                                <a href="{{ $documentUrl }}" style="color:#2563eb;">{{ $documentUrl }}</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

