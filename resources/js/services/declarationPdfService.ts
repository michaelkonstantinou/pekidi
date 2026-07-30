import axios from 'axios';

export default class DeclarationPdfService {
    /**
     * Fetch the PDF binary blob from the API.
     */
    public async fetchPdfBlob(declarationId: number): Promise<Blob> {
        const response = await axios.get(`/api/declarations/${declarationId}/pdf`, {
            responseType: 'blob',
        });

        return new Blob([response.data], { type: 'application/pdf' });
    }

    /**
     * Download the declaration PDF to the user's device.
     */
    public async download(declarationId: number): Promise<void> {
        const blob = await this.fetchPdfBlob(declarationId);
        const blobUrl = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = blobUrl;
        link.setAttribute('download', `declaration_${declarationId}.pdf`);
        document.body.appendChild(link);
        link.click();

        // Cleanup DOM and memory
        document.body.removeChild(link);
        window.URL.revokeObjectURL(blobUrl);
    }

    /**
     * Trigger the native browser print dialog for the declaration PDF via a hidden iframe.
     */
    public async print(declarationId: number): Promise<void> {
        const blob = await this.fetchPdfBlob(declarationId);
        const blobUrl = window.URL.createObjectURL(blob);

        return new Promise((resolve, reject) => {
            const iframe = document.createElement('iframe');
            iframe.style.position = 'fixed';
            iframe.style.right = '0';
            iframe.style.bottom = '0';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = '0';

            // Appending parameters forces PDF render engines to complete page layout upfront
            iframe.src = `${blobUrl}#toolbar=0&navpanes=0`;

            document.body.appendChild(iframe);

            iframe.onload = () => {
                // Give the browser's PDF engine 1 second to parse all pages (Parts A through E)
                setTimeout(() => {
                    try {
                        iframe.contentWindow?.focus();
                        iframe.contentWindow?.print();
                    } catch (err) {
                        reject(err);
                    } finally {
                        // Delay cleanup so print dialogue doesn't get garbage collected mid-print
                        setTimeout(() => {
                            document.body.removeChild(iframe);
                            window.URL.revokeObjectURL(blobUrl);
                            resolve();
                        }, 2000);
                    }
                }, 1000); // 1000ms delay ensures PDF multi-page layout is complete
            };

            iframe.onerror = (err) => {
                document.body.removeChild(iframe);
                window.URL.revokeObjectURL(blobUrl);
                reject(err);
            };
        });
    }

    /**
     * Helper to extract error message when Axios receives an error formatted as a Blob.
     */
    public async parseBlobError(error: any): Promise<string> {
        if (error?.response?.data instanceof Blob) {
            try {
                const text = await error.response.data.text();
                const jsonError = JSON.parse(text);
                return jsonError.message || 'Unauthorized action.';
            } catch {
                return 'An error occurred processing the request.';
            }
        }
        return error?.message || 'An unexpected error occurred.';
    }
}
