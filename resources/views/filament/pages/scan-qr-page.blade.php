<x-filament-panels::page>
    <div id="reader" width="600px"></div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            window.location.href = 'products/' + decodedText;
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
        }

        let config = {
            fps: 10,
            qrbox: {
                width: 700,
                height: 700
            },
            rememberLastUsedCamera: true,
            formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
            // Only support camera scan type.
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_FILE, Html5QrcodeScanType.SCAN_TYPE_CAMERA]
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", config,
            /* verbose= */
            false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</x-filament-panels::page>
