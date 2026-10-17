/**
 * Lapisan komunikasi API prototype.
 * Saat backend Laravel 12 siap, ganti requestDemo dengan fetch authenticated
 * tanpa mengubah komponen halaman. Prototype ini tidak mengirim data ke server.
 */
export const API_CONFIG = {
  baseUrl: '/api',
  version: 'v1',
  simulated: true,
  endpoints: {
    auth: { login: '/auth/login', logout: '/auth/logout', me: '/auth/me' },
    profile: '/profile',
    students: '/students',
    teachers: '/teachers',
    classes: '/classes',
    applicants: '/spmb/applicants',
    applicantStatus: '/spmb/status',
    verification: '/spmb/verifications',
    attendance: '/attendance',
    tasks: '/tasks',
    users: '/users',
    permissions: '/permissions'
  }
};

export function apiUrl(endpoint) {
  return `${API_CONFIG.baseUrl}/${API_CONFIG.version}${endpoint}`;
}

export async function requestDemo(endpoint, options = {}) {
  return { simulated: true, endpoint: apiUrl(endpoint), method: options.method || 'GET', data: options.body || null, message: 'Simulasi frontend — belum terhubung ke backend Laravel.' };
}
