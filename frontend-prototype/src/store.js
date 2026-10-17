import { students, teachers, classes, applicants, tasks, users, attendanceSeed, activitySeed } from './data.js';

const STORAGE_KEY = 'sekolahmu-demo-state-v1';
const copy = value => JSON.parse(JSON.stringify(value));
const seed = { students, teachers, classes, applicants, tasks, users, attendance: attendanceSeed, activities: activitySeed };
let state = load();
const listeners = new Set();

function load() {
  try {
    const saved = JSON.parse(localStorage.getItem(STORAGE_KEY));
    return saved ? { ...copy(seed), ...saved } : copy(seed);
  } catch { return copy(seed); }
}
function persist() { localStorage.setItem(STORAGE_KEY, JSON.stringify(state)); listeners.forEach(fn => fn(state)); }
function nowLabel() { return 'Hari ini, 10:24'; }
function addActivity(title, copyText, icon = 'check') { state.activities.unshift({ icon, title, copy: copyText, time: nowLabel() }); state.activities = state.activities.slice(0, 8); }
function nextId(items, prefix, width) { const max = items.reduce((highest, item) => Math.max(highest, Number(String(item.id || '').replace(/\D/g, '')) || 0), 0); return `${prefix}${String(max + 1).padStart(width, '0')}`; }
function renameClassReferences(oldName, newName) {
  state.students.forEach(student => { if (student.className === oldName) student.className = newName; });
  state.tasks.forEach(task => { if (task.className === oldName) task.className = newName; });
  state.teachers.forEach(teacher => { if (teacher.classes?.includes(oldName)) teacher.classes = teacher.classes.split(', ').map(name => name === oldName ? newName : name).join(', '); });
  Object.entries(state.attendance).forEach(([key, records]) => { const [date, className] = key.split('|'); if (className === oldName) { state.attendance[`${date}|${newName}`] = records; delete state.attendance[key]; } });
}
function removeClassReferences(className, fallback) {
  state.students.forEach(student => { if (student.className === className) student.className = fallback; });
  state.tasks.forEach(task => { if (task.className === className) task.className = fallback; });
  state.teachers.forEach(teacher => { if (teacher.classes?.includes(className)) teacher.classes = teacher.classes.split(', ').filter(name => name !== className).concat(fallback && !teacher.classes.includes(fallback) ? [fallback] : []).join(', '); });
  Object.keys(state.attendance).forEach(key => { if (key.endsWith(`|${className}`)) delete state.attendance[key]; });
}
export const store = {
  get() { return state; },
  reset() { state = copy(seed); persist(); },
  subscribe(fn) { listeners.add(fn); return () => listeners.delete(fn); },
  addStudent(data) { state.students.push({ ...data, id: nextId(state.students, 'M-', 5), status: data.status || 'Aktif', joined: '2026-06-24' }); addActivity('Data murid ditambahkan', `${data.name} ditambahkan ke ${data.className}.`, 'user'); persist(); },
  updateStudent(id, data) { const item = state.students.find(x => x.id === id); if (item) Object.assign(item, data); addActivity('Data murid diperbarui', `${data.name || item?.name || id} diperbarui oleh Admin demo.`, 'user'); persist(); },
  removeStudent(id) { const item = state.students.find(x => x.id === id); state.students = state.students.filter(x => x.id !== id); addActivity('Data murid dihapus', `${item?.name || id} dihapus dari data demo.`, 'trash'); persist(); },
  addTeacher(data) { state.teachers.push({ ...data, id: nextId(state.teachers, 'G-', 4), status: data.status || 'Aktif' }); addActivity('Data guru ditambahkan', `${data.name} ditambahkan sebagai guru demo.`, 'user'); persist(); },
  updateTeacher(id, data) { const item = state.teachers.find(x => x.id === id); if (item) Object.assign(item, data); persist(); },
  removeTeacher(id) { state.teachers = state.teachers.filter(x => x.id !== id); addActivity('Data guru dihapus', `${id} dihapus dari data demo.`, 'trash'); persist(); },
  addClass(data) { state.classes.push({ ...data, id: nextId(state.classes, 'K-', 3), capacity: Number(data.capacity || 32) }); addActivity('Kelas ditambahkan', `${data.name} ditambahkan ke data demo.`, 'book'); persist(); },
  updateClass(id, data) { const item = state.classes.find(x => x.id === id); if (item) { const oldName = item.name; Object.assign(item, { ...data, capacity: Number(data.capacity || item.capacity) }); if (oldName !== item.name) renameClassReferences(oldName, item.name); } persist(); },
  removeClass(id) { const item = state.classes.find(x => x.id === id); const fallback = state.classes.find(x => x.id !== id)?.name || ''; if (item) removeClassReferences(item.name, fallback); state.classes = state.classes.filter(x => x.id !== id); addActivity('Kelas dihapus', `${item?.name || id} dihapus; relasi demo dialihkan bila diperlukan.`, 'trash'); persist(); },
  addTask(data) { state.tasks.unshift({ ...data, id: nextId(state.tasks, 'T-', 4), status: data.status || 'Aktif' }); addActivity('Tugas baru dibuat', `${data.title} untuk ${data.className}.`, 'file'); persist(); },
  updateTask(id, data) { const item = state.tasks.find(x => x.id === id); if (item) Object.assign(item, data); addActivity('Tugas diperbarui', `${data.title || item?.title || id} diperbarui.`, 'file'); persist(); },
  removeTask(id) { state.tasks = state.tasks.filter(x => x.id !== id); addActivity('Tugas dihapus', `${id} dihapus dari data demo.`, 'trash'); persist(); },
  updateApplicantStatus(id, status, note = '') { const item = state.applicants.find(x => x.id === id); if (!item) return; item.status = status; if (note) item.note = note; item.history = item.history || []; item.history.push({ status, date: nowLabel(), by: 'Admin demo' }); addActivity('Status pendaftar diperbarui', `${item.name} ditandai ${status}.`, 'check'); persist(); },
  addApplicant(data) { state.applicants.unshift({ ...data, history: [{ status: 'Menunggu Verifikasi', date: nowLabel(), by: 'Formulir publik demo' }], documents: data.documents || { kartuKeluarga: 'Belum diperiksa', rapor: 'Belum diperiksa', akta: 'Belum diperiksa' } }); addActivity('Pendaftar baru masuk', `${data.name} mengirim formulir simulasi.`, 'clipboard'); persist(); },
  saveAttendance(date, className, records) { state.attendance[`${date}|${className}`] = records; addActivity('Absensi disimpan', `Absensi ${className} pada ${date}.`, 'calendar'); persist(); },
  getAttendance(date, className) { return copy(state.attendance[`${date}|${className}`] || {}); }
};
