import axios from 'axios';
import {ExportOptions} from "@/types";

export default class DeclarationPdfService {
    /**
     * Fetch the PDF binary blob from the API with custom export parameters.
     */
    public async fetchPdfBlob(declarationId: number, options: ExportOptions): Promise<{ blob: Blob; filename?: string }> {
        const response = await axios.post(`/api/declarations/${declarationId}/pdf`, {
            document_type: options?.documentType,
            include_personal: options?.includePersonal,
            include_spouse: options?.includeSpouse,
            include_children: options?.includeChildren,
        }, {
            responseType: 'blob',
        });

        // Try to parse filename from backend header if present
        let filename: string | undefined;
        const disposition = response.headers['content-disposition'];
        if (disposition && disposition.includes('filename=')) {
            const match = disposition.match(/filename="?([^";]+)"?/);
            if (match && match[1]) {
                filename = match[1];
            }
        }

        const blob = new Blob([response.data], { type: 'application/pdf' });
        return { blob, filename };
    }

    /**
     * Download the declaration PDF to the user's device.
     */
    public async download(declarationId: number, options: ExportOptions): Promise<void> {
        const { blob, filename } = await this.fetchPdfBlob(declarationId, options);
        const blobUrl = window.URL.createObjectURL(blob);
        const link = document.createElement('a');

        try {
            const fallbackName = `declaration_${declarationId}_${options?.documentType || 'official'}.pdf`;

            link.href = blobUrl;
            link.setAttribute('download', filename || fallbackName);
            document.body.appendChild(link);
            link.click();
        } finally {
            // Clean up DOM and release memory safely
            if (document.body.contains(link)) {
                document.body.removeChild(link);
            }
            window.URL.revokeObjectURL(blobUrl);
        }
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
