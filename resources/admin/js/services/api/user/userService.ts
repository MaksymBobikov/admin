import { apiClient } from '../../../utilites/apiClient';

export async function sendVerificationRequest(): Promise<boolean>{
    const { data } = await apiClient.post('/admin/email/verification-notification');

    return !!data?.success;
}
