// ==================== KONFIGURASI DATABASE ====================
const SPREADSHEET_ID    = '1iezUQsabqHxbUsiiDtLAzWm1jdO49EmRYfNaiDmbxDg';
const SESSION_EXPIRY    = 60 * 60 * 1000; // 1 jam

// ==================== ROUTING & WEB APP ENTRY POINT ====================
function redirectToLogin(msg) {
  const scriptUrl = ScriptApp.getService().getUrl();
  let url = scriptUrl + '?page=login';
  if (msg) url += '&msg=' + encodeURIComponent(msg);
  return HtmlService.createHtmlOutput(
    '<script>window.top.location.href="' + url + '";</script>' +
    '<p style="font-family:sans-serif;padding:20px;text-align:center;">Redirecting to login...</p>'
  );
}

function doGet(e) {
  let page      = '';
  let token     = '';
  let articleId = '';

  // 1. Ambil parameter dari e.parameter
  if (e && e.parameter) {
    if (e.parameter.page)      page      = String(e.parameter.page).toLowerCase().trim();
    if (e.parameter.token)     token     = String(e.parameter.token).trim();
    if (e.parameter.articleId) articleId = String(e.parameter.articleId).trim();
  }

  // 2. Fallback: Parse dari e.queryString jika e.parameter kosong
  if (e && e.queryString) {
    if (!page) {
      const m = e.queryString.match(/(?:^|&)page=([^&]*)/i);
      if (m && m[1]) page = decodeURIComponent(m[1]).toLowerCase().trim();
    }
    if (!token) {
      const m = e.queryString.match(/(?:^|&)token=([^&]*)/i);
      if (m && m[1]) token = decodeURIComponent(m[1]).trim();
    }
    if (!articleId) {
      const m = e.queryString.match(/(?:^|&)articleId=([^&]*)/i);
      if (m && m[1]) articleId = decodeURIComponent(m[1]).trim();
    }
  }

  const scriptUrl = ScriptApp.getService().getUrl();

  // 🔧 DEBUG ROUTE: Akses ?page=test untuk diagnosa
  if (page === 'test') {
    const info = JSON.stringify({
      page, token, articleId,
      queryString: (e && e.queryString) || '',
      parameter:   (e && e.parameter)   || {}
    }, null, 2);
    return HtmlService.createHtmlOutput(
      '<div style="font-family:monospace;padding:30px;background:#f0f8d3;min-height:100vh;">' +
      '<h2 style="color:#2d4a22;">✅ doGet DEBUG</h2>' +
      '<pre style="background:white;padding:20px;border-radius:12px;font-size:13px;line-height:1.7;overflow:auto;">' + info + '</pre>' +
      '</div>'
    );
  }

  // 1. HALAMAN LOGIN
  if (page === 'login') {
    const html = HtmlService.createHtmlOutputFromFile('login').getContent();
    const urlScript = '<script>window.__GAS_BASE_URL__ = "' + scriptUrl + '";<\/script>';
    const injected = html.replace('<body', urlScript + '<body');
    return HtmlService.createHtmlOutput(injected)
      .setTitle('Login SQR')
      .addMetaTag('viewport', 'width=device-width, initial-scale=1');
  }

  // 2. HALAMAN DASHBOARD (ROUTE SESUAI ROLE SESSION)
  if (page === 'dashboard') {
    if (!token) {
      return redirectToLogin('Session tidak valid atau sudah berakhir, silakan login kembali.');
    }
    const session = validateSession(token);
    if (!session) {
      return redirectToLogin('Session tidak valid atau sudah berakhir, silakan login kembali.');
    }

    const requestedRole = e && e.parameter ? e.parameter.role : null;
    if (requestedRole && session.role !== requestedRole && session.role !== 'admin') {
      return redirectToLogin('Akses ditolak: role Anda (' + session.role + ') tidak memiliki izin untuk halaman ini.');
    }

    function injectToken(filename, title) {
      const html      = HtmlService.createHtmlOutputFromFile(filename).getContent();
      const tokenScript = '<script>' +
        'window.__GAS_TOKEN__ = "' + token + '";' +
        'window.__GAS_BASE_URL__ = "' + scriptUrl + '";' +
        '<\/script>';
      const injected = html.replace('<body', tokenScript + '<body');
      return HtmlService.createHtmlOutput(injected)
        .setTitle(title)
        .addMetaTag('viewport', 'width=device-width, initial-scale=1');
    }

    if (session.role === 'admin')  return injectToken('admin_dashboard', 'Admin Dashboard SQR');
    if (session.role === 'ustadz') return injectToken('ustadz_dashboard', 'Ustadz Dashboard SQR');
    if (session.role === 'wali')   return injectToken('wali_dashboard', 'Wali Dashboard SQR');

    return redirectToLogin('Role tidak dikenali.');
  }

  // 3. DIRECT DASHBOARD ACCESS
  if (page === 'admin_dashboard' || page === 'wali_dashboard' || page === 'ustadz_dashboard') {
    const html = HtmlService.createHtmlOutputFromFile(page).getContent();
    const tokenScript = '<script>' +
      'window.__GAS_TOKEN__ = "' + token + '";' +
      'window.__GAS_BASE_URL__ = "' + scriptUrl + '";' +
      '<\/script>';
    const injected = html.replace('<body', tokenScript + '<body');
    return HtmlService.createHtmlOutput(injected)
      .setTitle('Dashboard SQR')
      .addMetaTag('viewport', 'width=device-width, initial-scale=1');
  }

  // 4. DEFAULT & HALAMAN PUBLIK (index / home, lokasi, kontak, struktur, artikel)
  let fileName = 'index';
  let pageTitle = 'PPDB Saung Quran Rabbani';

  if (page === 'lokasi') {
    fileName = 'lokasi';
    pageTitle = 'Lokasi – SQR';
  } else if (page === 'kontak') {
    fileName = 'kontak';
    pageTitle = 'Kontak – SQR';
  } else if (page === 'struktur') {
    fileName = 'struktur';
    pageTitle = 'Struktur Pengurus – SQR';
  } else if (page === 'artikel') {
    fileName = 'artikel';
    pageTitle = 'Artikel – SQR';
  }

  let content = '';
  try {
    content = HtmlService.createHtmlOutputFromFile(fileName).getContent();
  } catch(err) {
    content = HtmlService.createHtmlOutputFromFile('index').getContent();
  }

  const varsScript = '<script>' +
    'window.__GAS_BASE_URL__ = "' + scriptUrl + '";' +
    'window.__GAS_TOKEN__ = "' + token + '";' +
    'window.__ARTICLE_ID__ = "' + articleId + '";' +
    '<\/script>';
  const injected = content.replace('<body', varsScript + '<body');

  return HtmlService.createHtmlOutput(injected)
    .setTitle(pageTitle)
    .setXFrameOptionsMode(HtmlService.XFrameOptionsMode.ALLOWALL);
}

// Fungsi bantu untuk mendapatkan URL Web App secara dinamis
function getUrl() {
  return ScriptApp.getService().getUrl();
}


const PROOF_FOLDER_ID   = '19e9RzbowuEEZdarK4rMc6QwHL1Pd0spS';
const SECTION_FOLDER_ID = '1dALQ_u3bGo2BR7sectATTeKSKsjCV1oh';
const PROFILE_FOLDER_ID = '16Es5b0ocyqJQ5s7Qis1SmexnMhK32Fdk';
// Ganti dengan Folder ID folder "SQR_Article_Media" di Google Drive Anda
const ARTICLE_FOLDER_ID = '1C00Q_69CfAtErSzZg0kM90OMq5CybU8K';

function uploadProfilePhoto(sessionToken, fileBlob, fileName) {
  if (!validateSession(sessionToken)) throw new Error('Session tidak valid');
  let folder;
  try {
    folder = DriveApp.getFolderById(PROFILE_FOLDER_ID);
  } catch (e) {
    folder = DriveApp.createFolder('SQR_Profile_Photos');
  }
  // Rekonstruksi Blob jika fileBlob dikirim sebagai byte array object
  let blob = fileBlob;
  if (fileBlob && fileBlob.bytes) {
    const mimeType = (fileBlob.config && fileBlob.config.contentType) ? fileBlob.config.contentType : 'image/jpeg';
    blob = Utilities.newBlob(fileBlob.bytes, mimeType, fileName || 'profile_photo');
  }
  const file     = folder.createFile(blob);
  file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW);
  const imageUrl = 'https://drive.google.com/uc?id=' + file.getId();
  return { success: true, imageUrl };
}

function getUserProfile(sessionToken) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Session tidak valid. Silakan login kembali.');
  
  const sheet = getSheet('Users');
  const data  = sheet.getDataRange().getValues();
  const targetEmail  = String(session.email || '').trim().toLowerCase();
  const targetUserId = String(session.userId || '').trim();

  for (let i = 1; i < data.length; i++) {
    const rowUserId = String(data[i][0] || '').trim();
    const rowEmail  = String(data[i][1] || '').trim().toLowerCase();
    if ((targetUserId && rowUserId === targetUserId) || (targetEmail && rowEmail === targetEmail)) {
      return {
        success: true,
        userId:   data[i][0],
        email:    data[i][1],
        fullName: data[i][3],
        role:     data[i][4],
        classId:  data[i][5],
        address:  data[i][7] || '',
        photoUrl: data[i][8] || ''
      };
    }
  }
  throw new Error('Data profil user tidak ditemukan');
}

function updateUserProfileSelf(sessionToken, fullName, password, address, photoUrl) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Session tidak valid. Silakan login kembali.');
  
  const sheet = getSheet('Users');
  const data  = sheet.getDataRange().getValues();
  const targetEmail  = String(session.email || '').trim().toLowerCase();
  const targetUserId = String(session.userId || '').trim();

  for (let i = 1; i < data.length; i++) {
    const rowUserId = String(data[i][0] || '').trim();
    const rowEmail  = String(data[i][1] || '').trim().toLowerCase();
    if ((targetUserId && rowUserId === targetUserId) || (targetEmail && rowEmail === targetEmail)) {
      if (fullName) sheet.getRange(i + 1, 4).setValue(fullName);
      if (password && String(password).trim().length >= 6) sheet.getRange(i + 1, 3).setValue(password);
      if (typeof address !== 'undefined') sheet.getRange(i + 1, 8).setValue(address);
      if (typeof photoUrl !== 'undefined' && photoUrl) sheet.getRange(i + 1, 9).setValue(photoUrl);
      
      logAudit(session.userId, 'UPDATE_PROFILE_SELF', 'User mengupdate biodata diri', sessionToken);
      return { success: true, message: 'Profil berhasil diperbarui' };
    }
  }
  throw new Error('Data profil tidak dapat diperbarui');
}

function getSheet(name) {
  const ss = SpreadsheetApp.openById(SPREADSHEET_ID);
  let sheet = ss.getSheetByName(name);
  if (!sheet) {
    if (name === 'Income') {
      sheet = ss.insertSheet('Income');
      sheet.appendRow(['ID', 'Description', 'Amount', 'Category', 'Date', 'Notes', 'AdminId', 'CreatedAt']);
      sheet.getRange(1, 1, 1, 8).setFontWeight('bold').setBackground('#2d4a22').setFontColor('white');
      sheet.appendRow([Utilities.getUuid(), 'Donasi / Infaq Kas SQR (Default)', 500000, 'Infaq / Sedekah', new Date(), 'Kas Awal SQR', 'ADMIN', new Date()]);
    } else if (name === 'Expenses') {
      sheet = ss.insertSheet('Expenses');
      sheet.appendRow(['ID', 'Description', 'Amount', 'Category', 'Date', 'Notes', 'AdminId', 'CreatedAt']);
      sheet.getRange(1, 1, 1, 8).setFontWeight('bold').setBackground('#2d4a22').setFontColor('white');
      sheet.appendRow([Utilities.getUuid(), 'Pembelian Karpet & Al-Quran Baru (Default)', 250000, 'Keperluan SQR', new Date(), 'Nota Pembelian SQR', 'ADMIN', new Date()]);
    } else if (name === 'Payments') {
      sheet = ss.insertSheet('Payments');
      sheet.appendRow(['paymentId', 'santriId', 'amount', 'monthYear', 'paymentDate', 'status', 'notes', 'adminId']);
      sheet.getRange(1, 1, 1, 8).setFontWeight('bold').setBackground('#2d4a22').setFontColor('white');
    }
  }
  return sheet;
}

// ==================== SESSION MANAGEMENT (Persistent Sheet + CacheService) ====================
function login(email, password) {
  const sheet = getSheet('Users');
  const data  = sheet.getDataRange().getValues();
  const cleanEmail    = String(email || '').trim().toLowerCase();
  const cleanPassword = String(password || '').trim();

  for (let i = 1; i < data.length; i++) {
    const dbEmail  = String(data[i][1] || '').trim().toLowerCase();
    const dbPass   = String(data[i][2] || '').trim();
    const isActive = data[i][6];
    
    const activeOk = (isActive === null || typeof isActive === 'undefined' || String(isActive).trim() === '') 
      ? true 
      : (isActive === true || String(isActive).toLowerCase() === 'true');

    if (dbEmail === cleanEmail && dbPass === cleanPassword) {
      if (!activeOk) {
        return { success: false, message: 'Akun Anda sedang dinonaktifkan oleh Admin' };
      }
      const userId       = String(data[i][0] || dbEmail);
      const role         = String(data[i][4] || 'wali').trim().toLowerCase();
      const sessionToken = Utilities.getUuid();
      const longExpiry   = 24 * 60 * 60 * 1000; // 24 Jam
      const expires      = new Date().getTime() + longExpiry;
      const sessionData  = JSON.stringify({ userId, role, email: dbEmail, expires });
      
      // 1. Simpan di CacheService (Cepat)
      try {
        CacheService.getScriptCache().put(sessionToken, sessionData, 21600); // 6 jam di GAS cache
      } catch(e) {}

      // 2. Simpan di Sheet Sessions (Persisten / Tahan restart GAS)
      try {
        let sessSheet = getSheet('Sessions');
        if (!sessSheet) {
          const ss = SpreadsheetApp.openById(SPREADSHEET_ID);
          sessSheet = ss.insertSheet('Sessions');
          sessSheet.appendRow(['Token', 'UserId', 'Role', 'Email', 'Expires', 'CreatedAt']);
          sessSheet.getRange(1, 1, 1, 6).setFontWeight('bold').setBackground('#2d4a22').setFontColor('white');
        }
        sessSheet.appendRow([sessionToken, userId, role, dbEmail, expires, new Date()]);
      } catch(e) {}
      
      return { success: true, sessionToken, role, userId };
    }
  }
  return { success: false, message: 'Email atau password salah' };
}

function validateSession(sessionToken) {
  if (!sessionToken || sessionToken === "undefined" || sessionToken === "null") return null;
  const cleanToken = String(sessionToken).trim();
  const now = new Date().getTime();

  // 1. Cek dari CacheService
  try {
    const cache = CacheService.getScriptCache();
    const raw   = cache.get(cleanToken);
    if (raw) {
      const session = JSON.parse(raw);
      if (now <= session.expires) {
        return session;
      }
    }
  } catch(e) {}

  // 2. Fallback: Cek dari Sheet Sessions jika RAM Cache GAS ter-reset
  try {
    const ss = SpreadsheetApp.openById(SPREADSHEET_ID);
    const sessSheet = ss.getSheetByName('Sessions');
    if (sessSheet) {
      const data = sessSheet.getDataRange().getValues();
      for (let i = data.length - 1; i >= 1; i--) {
        if (String(data[i][0] || '').trim() === cleanToken) {
          const expires = Number(data[i][4] || 0);
          if (now <= expires) {
            const session = {
              userId:  String(data[i][1] || ''),
              role:    String(data[i][2] || 'wali').toLowerCase().trim(),
              email:   String(data[i][3] || ''),
              expires: expires
            };
            // Masukkan kembali ke CacheService agar panggilan berikutnya cepat
            try {
              CacheService.getScriptCache().put(cleanToken, JSON.stringify(session), 21600);
            } catch(e) {}
            return session;
          }
        }
      }
    }
  } catch(e) {}

  return null;
}

function logout(sessionToken) {
  if (!sessionToken) return true;
  try { CacheService.getScriptCache().remove(sessionToken); } catch(e) {}
  try {
    const ss = SpreadsheetApp.openById(SPREADSHEET_ID);
    const sessSheet = ss.getSheetByName('Sessions');
    if (sessSheet) {
      const data = sessSheet.getDataRange().getValues();
      for (let i = 1; i < data.length; i++) {
        if (String(data[i][0] || '').trim() === String(sessionToken).trim()) {
          sessSheet.deleteRow(i + 1);
          break;
        }
      }
    }
  } catch(e) {}
  return true;
}

// ==================== PERMISSION CHECK ====================
function hasPermission(sessionToken, requiredRole) {
  const session = validateSession(sessionToken);
  if (!session) return false;
  const role = String(session.role || '').trim().toLowerCase();
  if (requiredRole === 'admin')  return role === 'admin';
  if (requiredRole === 'ustadz') return role === 'ustadz' || role === 'admin';
  if (requiredRole === 'wali')   return role === 'wali'   || role === 'admin';
  return false;
}

// ==================== CONTENT MANAGER ====================
function getContent(key) {
  const sheet = getSheet('ContentManager');
  const data  = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (data[i][0] === key) return data[i][1];
  }
  return null;
}

function getAllContents() {
  const sheet = getSheet('ContentManager');
  const data  = sheet.getDataRange().getValues();
  const result = [];
  for (let i = 1; i < data.length; i++) {
    if (data[i][0]) {
      result.push({ key: data[i][0], value: data[i][1], type: data[i][2] });
    }
  }
  return result;
}

function updateContent(sessionToken, key, value) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet = getSheet('ContentManager');
  const data  = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (data[i][0] === key) {
      sheet.getRange(i + 1, 2).setValue(value);
      sheet.getRange(i + 1, 4).setValue(new Date());
      return true;
    }
  }
  sheet.appendRow([key, value, 'text', new Date()]);
  return true;
}

function updateMultipleContents(sessionToken, updates) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const session = validateSession(sessionToken);
  const sheet   = getSheet('ContentManager');
  const data    = sheet.getDataRange().getValues();
  for (let key in updates) {
    let found = false;
    for (let i = 1; i < data.length; i++) {
      if (data[i][0] === key) {
        sheet.getRange(i + 1, 2).setValue(updates[key]);
        sheet.getRange(i + 1, 4).setValue(new Date());
        found = true;
        break;
      }
    }
    if (!found) sheet.appendRow([key, updates[key], 'text', new Date()]);
  }
  logAudit(session.userId, 'UPDATE_MULTIPLE_CONTENTS', JSON.stringify(Object.keys(updates)), sessionToken);
  return true;
}

function getContentByCategory(category) {
  const sheet  = getSheet('ContentManager');
  const data   = sheet.getDataRange().getValues();
  const result = {};
  for (let i = 1; i < data.length; i++) {
    if (data[i][0] && data[i][0].startsWith(category + '_')) {
      result[data[i][0]] = data[i][1];
    }
  }
  return result;
}

// ==================== SECTION TOGGLE & IMAGE ====================
function getSectionStatus(sectionName) {
  const val = getContent(sectionName + '_active');
  if (val === null) return true;
  return val === 'true' || val === true;
}

function setSectionStatus(sessionToken, sectionName, isActive) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  return updateContent(sessionToken, sectionName + '_active', isActive ? 'true' : 'false');
}

function uploadSectionImage(sessionToken, sectionKey, fileBlob, fileName) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  let folder;
  try {
    folder = DriveApp.getFolderById(SECTION_FOLDER_ID);
  } catch (e) {
    folder = DriveApp.createFolder('SQR_Section_Images');
  }
  const file     = folder.createFile(fileBlob).setName(fileName);
  file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW);
  const imageUrl = 'https://drive.google.com/uc?id=' + file.getId();
  updateContent(sessionToken, sectionKey + '_image', imageUrl);
  return { success: true, imageUrl };
}

function uploadImageToDrive(sessionToken, base64Data, fileName, mimeType) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  if (!base64Data) throw new Error('Data gambar kosong');
  
  const folderName = 'SQR_Section_Images';
  let folder;
  try {
    const folders = DriveApp.getFoldersByName(folderName);
    folder = folders.hasNext() ? folders.next() : DriveApp.createFolder(folderName);
  } catch(e) {
    folder = DriveApp.createFolder(folderName);
  }
  
  const decoded  = Utilities.base64Decode(base64Data);
  const blob     = Utilities.newBlob(decoded, mimeType || 'image/jpeg', fileName || 'upload.jpg');
  const file     = folder.createFile(blob);
  file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW);
  
  const fileId   = file.getId();
  const url      = 'https://drive.google.com/uc?export=view&id=' + fileId;
  return { success: true, url: url, fileId: fileId };
}


// ==================== ARTIKEL MANAGEMENT ====================

function getArticles(page, limit) {
  const sheet = getSheet('Articles');
  if (!sheet) return { articles: [], total: 0, page: 1, totalPages: 1 };
  const data     = sheet.getDataRange().getValues();
  const pageNum  = Math.max(1, parseInt(page) || 1);
  const pageSize = Math.max(1, parseInt(limit) || 6);
  const all = [];
  for (let i = 1; i < data.length; i++) {
    if (!data[i][0]) continue;
    const isPublished = data[i][7];
    if (isPublished === false || String(isPublished).toLowerCase() === 'false') continue;
    all.push({
      articleId:   String(data[i][0] || ''),
      title:       String(data[i][1] || ''),
      excerpt:     String(data[i][2] || '').substring(0, 180),
      category:    String(data[i][3] || 'Umum'),
      mediaUrl:    String(data[i][4] || ''),
      mediaType:   String(data[i][5] || 'image'),
      authorName:  String(data[i][6] || 'Admin SQR'),
      publishedAt: String(data[i][8] || ''),
    });
  }
  all.reverse();
  const total      = all.length;
  const totalPages = Math.max(1, Math.ceil(total / pageSize));
  const start      = (pageNum - 1) * pageSize;
  return { articles: all.slice(start, start + pageSize), total, page: pageNum, totalPages };
}

function getArticleById(articleId) {
  const sheet = getSheet('Articles');
  if (!sheet) return null;
  const data = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (String(data[i][0]) === String(articleId)) {
      let contentBlocks = [];
      try { contentBlocks = JSON.parse(data[i][9] || '[]'); } catch(e) {}
      return {
        articleId:     String(data[i][0] || ''),
        title:         String(data[i][1] || ''),
        excerpt:       String(data[i][2] || ''),
        category:      String(data[i][3] || 'Umum'),
        mediaUrl:      String(data[i][4] || ''),
        mediaType:     String(data[i][5] || 'image'),
        authorName:    String(data[i][6] || 'Admin SQR'),
        isPublished:   data[i][7],
        publishedAt:   String(data[i][8] || ''),
        contentBlocks: contentBlocks
      };
    }
  }
  return null;
}

function getAllArticlesAdmin(sessionToken, page, limit) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet = getSheet('Articles');
  if (!sheet) return { articles: [], total: 0, page: 1, totalPages: 1 };
  const data     = sheet.getDataRange().getValues();
  const pageNum  = Math.max(1, parseInt(page) || 1);
  const pageSize = Math.max(1, parseInt(limit) || 10);
  const all = [];
  for (let i = 1; i < data.length; i++) {
    if (!data[i][0]) continue;
    all.push({
      articleId:   String(data[i][0] || ''),
      title:       String(data[i][1] || ''),
      category:    String(data[i][3] || 'Umum'),
      mediaType:   String(data[i][5] || 'image'),
      authorName:  String(data[i][6] || 'Admin SQR'),
      isPublished: data[i][7],
      publishedAt: String(data[i][8] || '')
    });
  }
  all.reverse();
  const total      = all.length;
  const totalPages = Math.max(1, Math.ceil(total / pageSize));
  const start      = (pageNum - 1) * pageSize;
  return { articles: all.slice(start, start + pageSize), total, page: pageNum, totalPages };
}

function submitArticle(sessionToken, articleData) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const session = validateSession(sessionToken);
  const sheet   = getSheet('Articles');
  if (!sheet) throw new Error('Sheet Articles tidak ditemukan. Buat sheet baru bernama "Articles" di spreadsheet SQR.');
  const articleId     = 'art_' + new Date().getTime() + '_' + Math.random().toString(36).substring(2, 7);
  const title         = String(articleData.title || '').trim();
  const excerpt       = String(articleData.excerpt || '').trim();
  const category      = String(articleData.category || 'Umum').trim();
  const mediaUrl      = String(articleData.mediaUrl || '').trim();
  const mediaType     = String(articleData.mediaType || 'image').trim();
  const authorName    = String(articleData.authorName || session.email || 'Admin SQR').trim();
  const isPublished   = articleData.isPublished === true || articleData.isPublished === 'true';
  const publishedAt   = new Date().toLocaleString('id-ID');
  const contentBlocks = JSON.stringify(articleData.contentBlocks || []);
  if (!title) throw new Error('Judul artikel wajib diisi');
  sheet.appendRow([articleId, title, excerpt, category, mediaUrl, mediaType, authorName, isPublished, publishedAt, contentBlocks]);
  logAudit(session.userId, 'CREATE_ARTICLE', articleId, sessionToken);
  return { success: true, articleId };
}

function updateArticle(sessionToken, articleId, articleData) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const session = validateSession(sessionToken);
  const sheet   = getSheet('Articles');
  if (!sheet) throw new Error('Sheet Articles tidak ditemukan');
  const data = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (String(data[i][0]) === String(articleId)) {
      const row = i + 1;
      if (articleData.title         !== undefined) sheet.getRange(row, 2).setValue(String(articleData.title).trim());
      if (articleData.excerpt       !== undefined) sheet.getRange(row, 3).setValue(String(articleData.excerpt).trim());
      if (articleData.category      !== undefined) sheet.getRange(row, 4).setValue(String(articleData.category).trim());
      if (articleData.mediaUrl      !== undefined) sheet.getRange(row, 5).setValue(String(articleData.mediaUrl).trim());
      if (articleData.mediaType     !== undefined) sheet.getRange(row, 6).setValue(String(articleData.mediaType).trim());
      if (articleData.isPublished   !== undefined) sheet.getRange(row, 8).setValue(articleData.isPublished === true || articleData.isPublished === 'true');
      if (articleData.contentBlocks !== undefined) sheet.getRange(row, 10).setValue(JSON.stringify(articleData.contentBlocks));
      logAudit(session.userId, 'UPDATE_ARTICLE', articleId, sessionToken);
      return { success: true };
    }
  }
  throw new Error('Artikel tidak ditemukan: ' + articleId);
}

function deleteArticle(sessionToken, articleId) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const session = validateSession(sessionToken);
  const sheet   = getSheet('Articles');
  if (!sheet) throw new Error('Sheet Articles tidak ditemukan');
  const data = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (String(data[i][0]) === String(articleId)) {
      sheet.deleteRow(i + 1);
      logAudit(session.userId, 'DELETE_ARTICLE', articleId, sessionToken);
      return { success: true };
    }
  }
  throw new Error('Artikel tidak ditemukan: ' + articleId);
}

function uploadArticleMedia(sessionToken, base64Data, fileName, mimeType) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  if (!base64Data) throw new Error('Data media kosong');
  let folder;
  try {
    folder = DriveApp.getFolderById(ARTICLE_FOLDER_ID);
  } catch(e) {
    try {
      const folders = DriveApp.getFoldersByName('SQR_Article_Media');
      folder = folders.hasNext() ? folders.next() : DriveApp.createFolder('SQR_Article_Media');
    } catch(e2) {
      folder = DriveApp.createFolder('SQR_Article_Media');
    }
  }
  const decoded = Utilities.base64Decode(base64Data);
  const blob    = Utilities.newBlob(decoded, mimeType || 'image/jpeg', fileName || 'media');
  const file    = folder.createFile(blob);
  file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW);
  const fileId = file.getId();
  const url    = 'https://lh3.googleusercontent.com/d/' + fileId;
  return { success: true, url, fileId, mimeType: mimeType || 'image/jpeg' };
}

// ==================== USER MANAGEMENT ====================
function getUsers(sessionToken) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet = getSheet('Users');
  if (!sheet) return [];
  const data  = sheet.getDataRange().getValues();
  const users = [];
  for (let i = 1; i < data.length; i++) {
    if (!data[i][0] && !data[i][1]) continue;
    const isActive = data[i][6];
    const activeOk = (isActive === null || typeof isActive === 'undefined' || String(isActive).trim() === '') 
      ? true 
      : (isActive === true || String(isActive).toLowerCase() === 'true');

    users.push({
      userId:    String(data[i][0] || ''),
      email:     String(data[i][1] || '').trim(),
      password:  String(data[i][2] || ''),
      fullName:  String(data[i][3] || ''),
      role:      String(data[i][4] || 'wali').trim().toLowerCase(),
      classId:   String(data[i][5] || ''),
      isActive:  activeOk,
      address:   String(data[i][7] || ''),
      photoUrl:  String(data[i][8] || ''),
      createdAt: String(data[i][9] || '')
    });
  }
  return users;
}



function addUser(sessionToken, email, password, fullName, role, classId, address, photoUrl) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet  = getSheet('Users');
  const userId = Utilities.getUuid();
  sheet.appendRow([userId, email, password, fullName, role, classId || '', true, address || '', photoUrl || '', new Date()]);
  const session = validateSession(sessionToken);
  logAudit(session ? session.userId : 'ADMIN', 'ADD_USER', 'Email: ' + email + ' | Role: ' + role, sessionToken);
  return userId;
}

function toggleUserStatus(sessionToken, email, newStatus) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet = getSheet('Users');
  const data  = sheet.getDataRange().getValues();
  const targetStatus = (newStatus === true || String(newStatus).toLowerCase() === 'true');
  
  for (let i = 1; i < data.length; i++) {
    if (data[i][1] === email || data[i][0] === email) {
      sheet.getRange(i + 1, 7).setValue(targetStatus);
      const session = validateSession(sessionToken);
      logAudit(session ? session.userId : 'ADMIN', 'TOGGLE_USER_STATUS', 'Email: ' + email + ' -> ' + targetStatus, sessionToken);
      return { success: true, isActive: targetStatus };
    }
  }
  throw new Error('User dengan email ' + email + ' tidak ditemukan');
}

function deleteUser(sessionToken, userIdOrEmail) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet = getSheet('Users');
  const data  = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (data[i][0] === userIdOrEmail || data[i][1] === userIdOrEmail) {
      const email = data[i][1];
      sheet.deleteRow(i + 1);
      const session = validateSession(sessionToken);
      logAudit(session ? session.userId : 'ADMIN', 'DELETE_USER', 'User ID/Email: ' + userIdOrEmail, sessionToken);
      return { success: true, message: 'User ' + email + ' berhasil dihapus' };
    }
  }
  throw new Error('User tidak ditemukan');
}

function updateUserProfileAdmin(sessionToken, userId, fullName, email, password, role, classId, address, photoUrl) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet = getSheet('Users');
  const data  = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (data[i][0] === userId || data[i][1] === email) {
      if (email)    sheet.getRange(i + 1, 2).setValue(email);
      if (password) sheet.getRange(i + 1, 3).setValue(password);
      if (fullName) sheet.getRange(i + 1, 4).setValue(fullName);
      if (role)     sheet.getRange(i + 1, 5).setValue(role);
      sheet.getRange(i + 1, 6).setValue(classId || '');
      if (typeof address !== 'undefined')  sheet.getRange(i + 1, 8).setValue(address);
      if (typeof photoUrl !== 'undefined') sheet.getRange(i + 1, 9).setValue(photoUrl);
      
      const session = validateSession(sessionToken);
      logAudit(session ? session.userId : 'ADMIN', 'UPDATE_USER_ADMIN', 'User: ' + userId, sessionToken);
      return { success: true };
    }
  }
  throw new Error('User tidak ditemukan');
}

function getUsersByRole(role) {
  const sheet = getSheet('Users');
  const data  = sheet.getDataRange().getValues();
  const users = [];
  for (let i = 1; i < data.length; i++) {
    if (data[i][4] === role && data[i][6] === true) {
      users.push({ userId: data[i][0], email: data[i][1] });
    }
  }
  return users;
}

// ==================== KELAS & SANTRI ====================
function getClasses() {
  const sheet = getSheet('Classes');
  const data  = sheet.getDataRange().getValues();
  const list  = [];
  for (let i = 1; i < data.length; i++) {
    list.push({ classId: data[i][0], className: data[i][1], description: data[i][2] });
  }
  return list;
}

function addClass(sessionToken, className, description) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet   = getSheet('Classes');
  const classId = Utilities.getUuid();
  sheet.appendRow([classId, className, description]);
  return classId;
}

function getSantriByClass(sessionToken, classId) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Session tidak valid');
  if (session.role === 'ustadz') {
    const userSheet = getSheet('Users');
    const userData  = userSheet.getDataRange().getValues();
    let userClassId = null;
    for (let i = 1; i < userData.length; i++) {
      if (userData[i][0] === session.userId) { userClassId = userData[i][5]; break; }
    }
    if (userClassId !== classId) throw new Error('Anda hanya dapat melihat kelas yang Anda ajar');
  }
  const sheet = getSheet('Santri');
  const data  = sheet.getDataRange().getValues();
  const list  = [];
  for (let i = 1; i < data.length; i++) {
    if (data[i][6] === classId && data[i][8] === true) {
      list.push({
        santriId:   data[i][0],
        fullName:   data[i][1],
        parentName: data[i][3],
        phone:      data[i][4],
        waliUserId: data[i][5]
      });
    }
  }
  return list;
}

function addSantri(sessionToken, fullName, parentName, phone, waliUserId, classId) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet    = getSheet('Santri');
  const santriId = Utilities.getUuid();
  sheet.appendRow([santriId, fullName, new Date(), parentName, phone, waliUserId, classId, new Date(), true]);
  return santriId;
}

function getAnakByWali(sessionToken) {
  const session = validateSession(sessionToken);
  if (!session || session.role !== 'wali') throw new Error('Akses ditolak');
  const sheet = getSheet('Santri');
  const data  = sheet.getDataRange().getValues();
  const anak  = [];
  for (let i = 1; i < data.length; i++) {
    if (data[i][5] === session.userId && data[i][8] === true) {
      anak.push({ santriId: data[i][0], fullName: data[i][1] });
    }
  }
  return anak;
}

// ==================== PAGINATION HELPERS ====================
function getPaginatedSantri(sessionToken, classId, page, limit) {
  page  = page  || 1;
  limit = limit || 10;
  const session = validateSession(sessionToken);
  if (!session || (session.role !== 'admin' && session.role !== 'ustadz')) throw new Error('Akses ditolak');
  const sheet = getSheet('Santri');
  const data  = sheet.getDataRange().getValues();
  let list    = [];
  for (let i = 1; i < data.length; i++) {
    if (data[i][6] === classId && data[i][8] === true) {
      list.push({ santriId: data[i][0], fullName: data[i][1], parentName: data[i][3], phone: data[i][4] });
    }
  }
  const start = (page - 1) * limit;
  return { santri: list.slice(start, start + limit), total: list.length, page, totalPages: Math.ceil(list.length / limit) };
}

function getPaginatedPayments(sessionToken, page, limit) {
  page  = page  || 1;
  limit = limit || 10;
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet    = getSheet('Payments');
  const data     = sheet.getDataRange().getValues();
  let payments   = [];
  for (let i = 1; i < data.length; i++) {
    payments.push({ id: data[i][0], santriId: data[i][1], amount: data[i][2], monthYear: data[i][3], date: data[i][4], status: data[i][5], notes: data[i][6] });
  }
  payments.sort((a, b) => new Date(b.date) - new Date(a.date));
  const start = (page - 1) * limit;
  return { payments: payments.slice(start, start + limit), total: payments.length, page, totalPages: Math.ceil(payments.length / limit) };
}

// ==================== PROGRESS SANTRI ====================
function addProgress(sessionToken, santriId, juzStart, juzEnd, surahMemorized, notes, type) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Session tidak valid');
  if (!hasPermission(sessionToken, 'ustadz')) throw new Error('Akses ditolak');

  const santriSheet = getSheet('Santri');
  const santriData  = santriSheet.getDataRange().getValues();
  let santriClassId = null;
  for (let i = 1; i < santriData.length; i++) {
    if (santriData[i][0] === santriId) { santriClassId = santriData[i][6]; break; }
  }
  if (session.role !== 'admin') {
    const userSheet  = getSheet('Users');
    const userData   = userSheet.getDataRange().getValues();
    let userClassId  = null;
    for (let i = 1; i < userData.length; i++) {
      if (userData[i][0] === session.userId) { userClassId = userData[i][5]; break; }
    }
    if (santriClassId !== userClassId) throw new Error('Santri tidak berada di kelas yang Anda ajar');
  }

  const progressSheet = getSheet('StudentProgress');
  const progressId    = Utilities.getUuid();
  progressSheet.appendRow([progressId, santriId, new Date(), juzStart, juzEnd, surahMemorized, notes, session.userId, type]);
  logAudit(session.userId, 'ADD_PROGRESS', 'Santri: ' + santriId, sessionToken);
  return progressId;
}

function getProgressSantri(sessionToken, santriId) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Session tidak valid');
  if (session.role === 'wali') {
    const santriSheet = getSheet('Santri');
    const santriData  = santriSheet.getDataRange().getValues();
    let isAnak = false;
    for (let i = 1; i < santriData.length; i++) {
      if (santriData[i][0] === santriId && santriData[i][5] === session.userId) { isAnak = true; break; }
    }
    if (!isAnak) throw new Error('Anda hanya bisa melihat progress anak Anda sendiri');
  }
  const sheet     = getSheet('StudentProgress');
  const data      = sheet.getDataRange().getValues();
  const progresses = [];
  for (let i = 1; i < data.length; i++) {
    if (data[i][1] === santriId) {
      progresses.push({
        date:           data[i][2],
        juzStart:       data[i][3],
        juzEnd:         data[i][4],
        surahMemorized: data[i][5],
        notes:          data[i][6],
        type:           data[i][8]
      });
    }
  }
  return progresses;
}

// ==================== PEMBAYARAN SPP ====================
function getUnpaidMonths(sessionToken, santriId) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Session tidak valid');
  
  if (session.role === 'wali') {
    const santriSheet = getSheet('Santri');
    if (santriSheet) {
      const santriData = santriSheet.getDataRange().getValues();
      let isAnak = false;
      for (let i = 1; i < santriData.length; i++) {
        if (String(santriData[i][0]) === String(santriId) && String(santriData[i][5]) === String(session.userId)) {
          isAnak = true;
          break;
        }
      }
      if (!isAnak) throw new Error('Santri tidak terdaftar sebagai anak anda');
    }
  }

  // Bulan yang sudah lunas
  const paidMonths = new Set();
  const paymentSheet = getSheet('Payments');
  if (paymentSheet) {
    const pData = paymentSheet.getDataRange().getValues();
    for (let i = 1; i < pData.length; i++) {
      if (String(pData[i][1]) === String(santriId) && (pData[i][5] === 'paid' || pData[i][5] === 'verified')) {
        paidMonths.add(String(pData[i][3]).trim().toLowerCase());
      }
    }
  }

  // Bulan yang sedang pending
  const pendingMonths = new Set();
  const verifSheet = getSheet('PaymentVerifications');
  if (verifSheet) {
    const vData = verifSheet.getDataRange().getValues();
    for (let i = 1; i < vData.length; i++) {
      if (String(vData[i][1]) === String(santriId) && String(vData[i][5]).toLowerCase() === 'pending') {
        pendingMonths.add(String(vData[i][3]).trim().toLowerCase());
      }
    }
  }

  const namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
  const now = new Date();
  const unpaidList = [];
  
  // Ambil 6 bulan terakhir s/d bulan berjalan
  for (let i = 5; i >= 0; i--) {
    const d = new Date(now.getFullYear(), now.getMonth() - i, 1);
    const monthStr = namaBulan[d.getMonth()] + ' ' + d.getFullYear();
    const keyLower = monthStr.toLowerCase();
    if (!paidMonths.has(keyLower) && !pendingMonths.has(keyLower)) {
      unpaidList.push(monthStr);
    }
  }
  
  return unpaidList;
}

function getOutstandingPayments(sessionToken, santriId) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Session tidak valid');
  if (session.role === 'wali') {
    const santriSheet = getSheet('Santri');
    const santriData  = santriSheet.getDataRange().getValues();
    let isValid = false;
    for (let i = 1; i < santriData.length; i++) {
      if (santriData[i][0] === santriId && santriData[i][5] === session.userId) { isValid = true; break; }
    }
    if (!isValid) throw new Error('Akses ditolak');
  }
  const paymentSheet = getSheet('Payments');
  const paymentData  = paymentSheet.getDataRange().getValues();
  const paidMonths   = new Set();
  for (let i = 1; i < paymentData.length; i++) {
    if (paymentData[i][1] === santriId && paymentData[i][5] === 'paid') {
      paidMonths.add(String(paymentData[i][3]));
    }
  }
  const santriSheet = getSheet('Santri');
  const santriData  = santriSheet.getDataRange().getValues();
  let enrollmentDate = null;
  for (let i = 1; i < santriData.length; i++) {
    if (santriData[i][0] === santriId) { enrollmentDate = new Date(santriData[i][7]); break; }
  }
  if (!enrollmentDate) return [];
  const now    = new Date();
  const months = [];
  let current  = new Date(enrollmentDate.getFullYear(), enrollmentDate.getMonth(), 1);
  while (current <= now) {
    const monthKey = current.getFullYear() + '-' + String(current.getMonth() + 1).padStart(2, '0');
    if (!paidMonths.has(monthKey)) months.push(monthKey);
    current.setMonth(current.getMonth() + 1);
  }
  return months;
}

function getPaymentHistory(sessionToken, santriId) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Session tidak valid');
  if (session.role === 'wali') {
    const santriSheet = getSheet('Santri');
    const santriData  = santriSheet.getDataRange().getValues();
    let isValid = false;
    for (let i = 1; i < santriData.length; i++) {
      if (santriData[i][0] === santriId && santriData[i][5] === session.userId) { isValid = true; break; }
    }
    if (!isValid) throw new Error('Akses ditolak');
  }
  const sheet   = getSheet('Payments');
  const data    = sheet.getDataRange().getValues();
  const history = [];
  for (let i = 1; i < data.length; i++) {
    if (data[i][1] === santriId) {
      history.push({ amount: data[i][2], monthYear: data[i][3], date: data[i][4], status: data[i][5] });
    }
  }
  return history;
}

// ==================== PEMBAYARAN DENGAN BUKTI ====================
function submitPaymentProof(sessionToken, santriId, amount, monthYear, proofFileBlob, fileName) {
  const session = validateSession(sessionToken);
  if (!session || session.role !== 'wali') throw new Error('Hanya wali yang dapat mengirim bukti');
  const santriSheet = getSheet('Santri');
  const santriData  = santriSheet.getDataRange().getValues();
  let isAnak = false;
  for (let i = 1; i < santriData.length; i++) {
    if (santriData[i][0] === santriId && santriData[i][5] === session.userId) { isAnak = true; break; }
  }
  if (!isAnak) throw new Error('Santri tidak terdaftar sebagai anak anda');
  let folder;
  try {
    folder = DriveApp.getFolderById(PROOF_FOLDER_ID);
  } catch (e) {
    folder = DriveApp.createFolder('Bukti_Pembayaran_SQR');
  }
  // Rekonstruksi GAS Blob dari byte array yang dikirim client
  // proofFileBlob = { config: { contentType: '...' }, bytes: [...] }
  const mimeType = (proofFileBlob.config && proofFileBlob.config.contentType) ? proofFileBlob.config.contentType : 'application/octet-stream';
  const blob     = Utilities.newBlob(proofFileBlob.bytes, mimeType, fileName || 'bukti_pembayaran');
  const file     = folder.createFile(blob);
  file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW);
  const proofUrl = 'https://lh3.googleusercontent.com/d/' + file.getId();
  const verifSheet = getSheet('PaymentVerifications');
  const id         = Utilities.getUuid();
  verifSheet.appendRow([id, santriId, amount, monthYear, proofUrl, 'pending', '', new Date(), null, null]);
  const admins = getUsersByRole('admin');
  admins.forEach(admin => {
    createNotification(admin.userId, 'Verifikasi Pembayaran',
      'Santri ' + santriId + ' mengirim bukti pembayaran SPP bulan ' + monthYear,
      'payment_pending', id);
  });
  logAudit(session.userId, 'SUBMIT_PAYMENT_PROOF', 'Santri ' + santriId + ' bulan ' + monthYear, sessionToken);
  return { success: true, message: 'Bukti terkirim, menunggu verifikasi admin' };
}

function getPendingVerifications(sessionToken, page, limit) {
  page  = page  || 1;
  limit = limit || 10;
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet    = getSheet('PaymentVerifications');
  const data     = sheet.getDataRange().getValues();
  let pendings   = [];
  for (let i = 1; i < data.length; i++) {
    if (data[i][5] === 'pending') {
      pendings.push({ id: data[i][0], santriId: data[i][1], amount: data[i][2], monthYear: data[i][3], proofUrl: data[i][4], submittedAt: data[i][7] });
    }
  }
  pendings.sort((a, b) => new Date(b.submittedAt) - new Date(a.submittedAt));
  const start = (page - 1) * limit;
  return { verifications: pendings.slice(start, start + limit), total: pendings.length, page, totalPages: Math.ceil(pendings.length / limit) };
}

function verifyPayment(sessionToken, verificationId, status, adminNotes) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const session  = validateSession(sessionToken);
  const sheet    = getSheet('PaymentVerifications');
  const data     = sheet.getDataRange().getValues();
  let rowIndex   = -1;
  let verifData;
  for (let i = 1; i < data.length; i++) {
    if (data[i][0] === verificationId) { rowIndex = i + 1; verifData = data[i]; break; }
  }
  if (rowIndex === -1) throw new Error('Verifikasi tidak ditemukan');
  const santriId  = verifData[1];
  const amount    = verifData[2];
  const monthYear = verifData[3];
  sheet.getRange(rowIndex, 6).setValue(status);
  sheet.getRange(rowIndex, 7).setValue(adminNotes);
  sheet.getRange(rowIndex, 9).setValue(new Date());
  sheet.getRange(rowIndex, 10).setValue(session.userId);
  const santriSheet = getSheet('Santri');
  const santriRows  = santriSheet.getDataRange().getValues();
  let waliUserId    = null;
  for (let i = 1; i < santriRows.length; i++) {
    if (santriRows[i][0] === santriId) { waliUserId = santriRows[i][5]; break; }
  }
  let waliEmail = '';
  if (waliUserId) {
    const userSheet = getSheet('Users');
    const userData  = userSheet.getDataRange().getValues();
    for (let i = 1; i < userData.length; i++) {
      if (userData[i][0] === waliUserId) { waliEmail = userData[i][1]; break; }
    }
  }
  if (status === 'verified') {
    const paymentSheet = getSheet('Payments');
    const paymentId    = Utilities.getUuid();
    paymentSheet.appendRow([paymentId, santriId, amount, monthYear, new Date(), 'paid', adminNotes, session.userId]);
    if (waliEmail) {
      MailApp.sendEmail({
        to: waliEmail,
        subject: '✅ Verifikasi Pembayaran SPP SQR',
        htmlBody: 'Assalamualaikum,<br><br>Pembayaran SPP bulan <b>' + monthYear + '</b> telah diverifikasi dan dinyatakan <b style="color:green;">LUNAS</b>.<br><br>Saung Quran Rabbani'
      });
    }
    if (waliUserId) createNotification(waliUserId, 'Pembayaran Diverifikasi', 'Pembayaran SPP bulan ' + monthYear + ' telah diverifikasi dan lunas.', 'payment_verified', verificationId);
  } else if (status === 'rejected') {
    if (waliEmail) {
      MailApp.sendEmail({
        to: waliEmail,
        subject: '❌ Verifikasi Pembayaran SPP SQR Ditolak',
        htmlBody: 'Assalamualaikum,<br><br>Pembayaran SPP bulan <b>' + monthYear + '</b> ditolak. Catatan: <i>' + adminNotes + '</i>.<br>Silakan upload ulang bukti yang valid.<br><br>Saung Quran Rabbani'
      });
    }
    if (waliUserId) createNotification(waliUserId, 'Pembayaran Ditolak', 'Pembayaran SPP bulan ' + monthYear + ' ditolak. Catatan: ' + adminNotes, 'payment_rejected', verificationId);
  }
  logAudit(session.userId, 'VERIFY_PAYMENT', 'Verifikasi ' + verificationId + ' -> ' + status, sessionToken);
  return true;
}

// ==================== NOTIFIKASI ====================
function createNotification(userId, title, message, type, relatedId) {
  const sheet = getSheet('Notifications');
  const id    = Utilities.getUuid();
  sheet.appendRow([id, userId, title, message, type, false, false, new Date(), relatedId || null]);
  return id;
}

function getUserNotifications(sessionToken, page, limit) {
  page  = page  || 1;
  limit = limit || 10;
  try {
    const session = validateSession(sessionToken);
    if (!session) return { notifications: [], total: 0, unreadCount: 0, page: 1, totalPages: 1 };
    const sheet  = getSheet('Notifications');
    if (!sheet) return { notifications: [], total: 0, unreadCount: 0, page: 1, totalPages: 1 };
    const data   = sheet.getDataRange().getValues();
    let notifs   = [];
    let unreadCount = 0;
    for (let i = 1; i < data.length; i++) {
      if (!data[i][0]) continue;
      if (data[i][6] === true || String(data[i][6]).toLowerCase() === 'true') continue; // deleted
      if (String(data[i][1]) === String(session.userId) || String(data[i][1]) === 'ALL') {
        const isRead = data[i][5] === true || String(data[i][5]).toLowerCase() === 'true';
        if (!isRead) unreadCount++;
        notifs.push({
          id: String(data[i][0]),
          title: String(data[i][2] || ''),
          message: String(data[i][3] || ''),
          type: String(data[i][4] || ''),
          isRead: isRead,
          createdAt: data[i][7] ? new Date(data[i][7]).toLocaleString('id-ID') : '',
          relatedId: String(data[i][8] || '')
        });
      }
    }
    notifs.reverse();
    const start = (page - 1) * limit;
    const paginated = notifs.slice(start, start + limit);
    return {
      notifications: paginated,
      total: notifs.length,
      unreadCount: unreadCount,
      page: page,
      totalPages: Math.ceil(notifs.length / limit) || 1
    };
  } catch(e) {
    console.error('getUserNotifications error:', e);
    return { notifications: [], total: 0, unreadCount: 0, page: 1, totalPages: 1 };
  }
}

function markAllNotificationsAsRead(sessionToken) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Unauthorized');
  const sheet = getSheet('Notifications');
  if (!sheet) return { success: true, count: 0 };
  const data = sheet.getDataRange().getValues();
  const isAdmin = session.role === 'admin';
  let count = 0;
  for (let i = 1; i < data.length; i++) {
    const isDeleted = data[i][6] === true || String(data[i][6]).toLowerCase() === 'true';
    if (isDeleted) continue;
    const isRead = data[i][5] === true || String(data[i][5]).toLowerCase() === 'true';
    if (isRead) continue;
    
    const notifOwner = String(data[i][1] || '');
    const isOwner = notifOwner === session.userId ||
                    (isAdmin && (notifOwner === 'ADMIN' || notifOwner === session.userId || notifOwner === ''));
    if (isOwner) {
      sheet.getRange(i + 1, 6).setValue(true);
      count++;
    }
  }
  logAudit(session.userId, 'MARK_ALL_NOTIFS_READ', 'Total dibaca: ' + count, sessionToken);
  return { success: true, count: count };
}

function markNotificationAsRead(sessionToken, notificationId) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Unauthorized');
  const sheet = getSheet('Notifications');
  const data  = sheet.getDataRange().getValues();
  const isAdmin = session.role === 'admin';
  for (let i = 1; i < data.length; i++) {
    if (String(data[i][0]) !== String(notificationId)) continue;
    const notifOwner = String(data[i][1] || '');
    // Admin bisa mark semua notifikasi yang visible untuknya
    const isOwner = notifOwner === session.userId ||
                    (isAdmin && (notifOwner === 'ADMIN' || notifOwner === session.userId || notifOwner === ''));
    if (isOwner) {
      sheet.getRange(i + 1, 6).setValue(true);
      logAudit(session.userId, 'MARK_NOTIF_READ', 'Notifikasi ' + notificationId, sessionToken);
      return true;
    }
  }
  return false;
}

function deleteNotification(sessionToken, notificationId) {
  const session = validateSession(sessionToken);
  if (!session) throw new Error('Unauthorized');
  const sheet = getSheet('Notifications');
  const data  = sheet.getDataRange().getValues();
  const isAdmin = session.role === 'admin';
  for (let i = 1; i < data.length; i++) {
    if (String(data[i][0]) !== String(notificationId)) continue;
    const notifOwner = String(data[i][1] || '');
    // Admin bisa hapus semua notifikasi yang visible untuknya
    const isOwner = notifOwner === session.userId ||
                    (isAdmin && (notifOwner === 'ADMIN' || notifOwner === session.userId || notifOwner === ''));
    if (isOwner) {
      sheet.getRange(i + 1, 7).setValue(true);
      logAudit(session.userId, 'DELETE_NOTIF', 'Notifikasi ' + notificationId, sessionToken);
      return true;
    }
  }
  return false;
}

// ==================== LAPORAN KEUANGAN & KAS SQR ====================
function addIncome(sessionToken, description, amount, category, date, notes) {
  const session = validateSession(sessionToken);
  let sheet = getSheet('Income');
  if (!sheet) {
    const ss = SpreadsheetApp.openById(SPREADSHEET_ID);
    sheet = ss.insertSheet('Income');
    sheet.appendRow(['ID', 'Description', 'Amount', 'Category', 'Date', 'Notes', 'AdminId', 'CreatedAt']);
    sheet.getRange(1, 1, 1, 8).setFontWeight('bold').setBackground('#2d4a22').setFontColor('white');
  }
  const id = 'inc_' + Utilities.getUuid().substring(0, 8);
  const incDate = date ? new Date(date) : new Date();
  const formattedDate = !isNaN(incDate.getTime()) ? incDate.toISOString().split('T')[0] : new Date().toISOString().split('T')[0];
  const adminId = (session && session.userId) ? session.userId : 'user_admin';
  
  sheet.appendRow([id, description, Number(amount), category || 'Infaq / Sedekah', formattedDate, notes || '', adminId, new Date()]);
  logAudit(adminId, 'ADD_INCOME', 'Pemasukan Kas: ' + description + ' | Rp ' + amount, sessionToken);
  return { success: true, id: id, message: 'Pemasukan kas berhasil dicatat' };
}

function addExpense(sessionToken, description, amount, category, date, notes) {
  const session = validateSession(sessionToken);
  let sheet = getSheet('Expenses');
  if (!sheet) {
    const ss = SpreadsheetApp.openById(SPREADSHEET_ID);
    sheet = ss.insertSheet('Expenses');
    sheet.appendRow(['ID', 'Description', 'Amount', 'Category', 'Date', 'Notes', 'AdminId', 'CreatedAt']);
    sheet.getRange(1, 1, 1, 8).setFontWeight('bold').setBackground('#2d4a22').setFontColor('white');
  }
  const id = 'exp_' + Utilities.getUuid().substring(0, 8);
  const expDate = date ? new Date(date) : new Date();
  const formattedDate = !isNaN(expDate.getTime()) ? expDate.toISOString().split('T')[0] : new Date().toISOString().split('T')[0];
  const adminId = (session && session.userId) ? session.userId : 'user_admin';
  
  sheet.appendRow([id, description, Number(amount), category || 'Keperluan SQR', formattedDate, notes || '', adminId, new Date()]);
  logAudit(adminId, 'ADD_EXPENSE', 'Pengeluaran Kas: ' + description + ' | Rp ' + amount, sessionToken);
  return { success: true, id: id, message: 'Pengeluaran kas berhasil dicatat' };
}

function getFinancialReport(sessionToken) {
  try {
    let totalSPP          = 0;
    let totalOtherIncome  = 0;
    let totalExpense      = 0;
    const perMonth        = {};
    const transactions    = [];

    function parseDate(rawDate) {
      if (!rawDate) return new Date();
      if (rawDate instanceof Date) return rawDate;
      const d = new Date(String(rawDate).trim());
      return isNaN(d.getTime()) ? new Date() : d;
    }

    function parseMonth(rawDate, rawMonthYear) {
      if (rawMonthYear && String(rawMonthYear).trim().match(/^\d{4}-\d{2}$/)) {
        return String(rawMonthYear).trim();
      }
      const d = parseDate(rawDate);
      const yyyy = d.getFullYear();
      const mm = String(d.getMonth() + 1).padStart(2, '0');
      return yyyy + '-' + mm;
    }

    // 1. Read Payments Sheet (Pemasukan SPP)
    const paySheet = getSheet('Payments');
    if (paySheet) {
      const payData = paySheet.getDataRange().getValues();
      for (let i = 1; i < payData.length; i++) {
        const row = payData[i];
        if (!row || !row[0]) continue;
        const status = String(row[5] || '').toLowerCase().trim();
        if (status === 'paid' || status === 'verified' || status === 'lunas' || status === '') {
          const amount = Number(row[2] || 0);
          const month  = parseMonth(row[4], row[3]);
          const date   = parseDate(row[4]);
          
          totalSPP += amount;
          perMonth[month] = (perMonth[month] || 0) + amount;
          
          transactions.push({
            id: String(row[0] || ('pay_' + i)),
            type: 'pemasukan',
            title: 'Pembayaran SPP Bulan ' + (row[3] || month) + ' (Santri ID: ' + (row[1] || '-') + ')',
            amount: amount,
            category: 'SPP Santri',
            date: date.toISOString(),
            monthYear: month,
            notes: String(row[6] || 'Lunas terverifikasi')
          });
        }
      }
    }

    // 2. Read Income Sheet (Infaq, Sedekah, Donasi, Amal)
    const incSheet = getSheet('Income');
    if (incSheet) {
      const incData = incSheet.getDataRange().getValues();
      for (let i = 1; i < incData.length; i++) {
        const row = incData[i];
        if (!row || !row[0]) continue;
        const amount = Number(row[2] || 0);
        if (amount > 0) {
          const date  = parseDate(row[4]);
          const month = parseMonth(row[4], null);
          
          totalOtherIncome += amount;
          perMonth[month] = (perMonth[month] || 0) + amount;

          transactions.push({
            id: String(row[0]),
            type: 'pemasukan',
            title: String(row[1] || 'Infaq / Donasi'),
            amount: amount,
            category: String(row[3] || 'Infaq / Sedekah'),
            date: date.toISOString(),
            monthYear: month,
            notes: String(row[5] || '-')
          });
        }
      }
    }

    // 3. Read Expenses Sheet (Pengeluaran / Keperluan SQR)
    const expSheet = getSheet('Expenses');
    if (expSheet) {
      const expData = expSheet.getDataRange().getValues();
      for (let i = 1; i < expData.length; i++) {
        const row = expData[i];
        if (!row || !row[0]) continue;
        const amount = Number(row[2] || 0);
        if (amount > 0) {
          const date  = parseDate(row[4]);
          const month = parseMonth(row[4], null);
          
          totalExpense += amount;

          transactions.push({
            id: String(row[0]),
            type: 'pengeluaran',
            title: String(row[1] || 'Pengeluaran Kas'),
            amount: amount,
            category: String(row[3] || 'Keperluan SQR'),
            date: date.toISOString(),
            monthYear: month,
            notes: String(row[5] || '-')
          });
        }
      }
    }

    transactions.sort((a, b) => new Date(b.date) - new Date(a.date));
    const totalIncome = totalSPP + totalOtherIncome;
    const saldoKas    = totalIncome - totalExpense;

    return { 
      totalIncome: totalIncome || 0,
      totalSPP: totalSPP || 0,
      totalOtherIncome: totalOtherIncome || 0,
      totalExpense: totalExpense || 0, 
      saldoKas: saldoKas || 0, 
      perMonth: perMonth || {}, 
      recentTransactions: transactions || [] 
    };
  } catch(e) {
    console.error('getFinancialReport error:', e);
    return {
      totalIncome: 0,
      totalSPP: 0,
      totalOtherIncome: 0,
      totalExpense: 0,
      saldoKas: 0,
      perMonth: {},
      recentTransactions: [],
      error: String(e.message || e)
    };
  }
}

// ==================== AUDIT LOG ====================
function logAudit(userId, action, details, sessionToken) {
  try {
    const sheet = getSheet('AuditLog');
    sheet.appendRow([Utilities.getUuid(), userId, action, details, '', '', new Date()]);
  } catch (e) {
    console.error('logAudit error:', e);
  }
}

// =====================================================
// TAMBAHKAN FUNGSI INI KE DALAM Kode.gs
// (Tempel di bagian bawah, sebelum function doGet)
// =====================================================

// ==================== FORM PPDB ====================
// Fungsi ini dipanggil dari index.html saat santri baru mengisi form pendaftaran
// Data akan masuk ke sheet "PPDB" di Google Spreadsheet

function submitPPDB(data) {
  try {
    const sheet = getSheet('PPDB');
    
    // Jika sheet belum ada, buat otomatis dengan header
    if (!sheet) {
      const ss      = SpreadsheetApp.openById(SPREADSHEET_ID);
      const newSheet = ss.insertSheet('PPDB');
      newSheet.appendRow([
        'ID', 'Timestamp', 'Nama Santri', 'Usia',
        'Nama Ortu/Wali', 'No. WhatsApp', 'Kelas Diminati', 'Status'
      ]);
      // Format header
      newSheet.getRange(1, 1, 1, 8).setFontWeight('bold').setBackground('#2d4a22').setFontColor('white');
    }
    
    const targetSheet = getSheet('PPDB');
    const id          = Utilities.getUuid();
    
    targetSheet.appendRow([
      id,
      data.timestamp || new Date().toLocaleString('id-ID'),
      data.nama  || '',
      data.usia  || '',
      data.ortu  || '',
      data.wa    || '',
      data.kelas || '',
      'Baru'  // status default
    ]);
    
    // Kirim notifikasi ke semua admin
    const admins = getUsersByRole('admin');
    admins.forEach(function(admin) {
      createNotification(
        admin.userId,
        '📋 Pendaftar Baru PPDB',
        'Nama: ' + data.nama + ' | WA: ' + data.wa + ' | Kelas: ' + data.kelas,
        'ppdb_new',
        id
      );
    });
    
    return { success: true, id: id };
    
  } catch (e) {
    console.error('submitPPDB error:', e);
    return { success: false, message: e.message };
  }
}

// ==================== PPDB MANAGEMENT (ADMIN) ====================
function getPPDBList(sessionToken, page, limit, statusFilter, searchQuery) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  page = page || 1;
  limit = limit || 10;
  
  const sheet = getSheet('PPDB');
  if (!sheet) return { ppdbList: [], total: 0, page: 1, totalPages: 1, stats: { total: 0, baru: 0, dihubungi: 0, diterima: 0, ditolak: 0 } };
  
  const data = sheet.getDataRange().getValues();
  const list = [];
  const stats = { total: 0, baru: 0, dihubungi: 0, diterima: 0, ditolak: 0 };
  
  const cleanSearch = String(searchQuery || '').trim().toLowerCase();
  const cleanFilter = String(statusFilter || 'all').trim().toLowerCase();
  
  for (let i = 1; i < data.length; i++) {
    if (!data[i][0] && !data[i][2]) continue;
    
    const id        = String(data[i][0] || '');
    const timestamp = String(data[i][1] || '');
    const nama      = String(data[i][2] || '');
    const usia      = String(data[i][3] || '');
    const ortu      = String(data[i][4] || '');
    const wa        = String(data[i][5] || '');
    const kelas     = String(data[i][6] || '');
    const status    = String(data[i][7] || 'Baru').trim();
    
    // Hitung statistik keseluruhan
    stats.total++;
    const sLower = status.toLowerCase();
    if (sLower.includes('baru'))       stats.baru++;
    else if (sLower.includes('hubung')) stats.dihubungi++;
    else if (sLower.includes('terima')) stats.diterima++;
    else if (sLower.includes('tolak'))  stats.ditolak++;
    
    // Filter Status
    if (cleanFilter !== 'all' && sLower !== cleanFilter) {
      if (cleanFilter === 'baru' && !sLower.includes('baru')) continue;
      if (cleanFilter === 'dihubungi' && !sLower.includes('hubung')) continue;
      if (cleanFilter === 'diterima' && !sLower.includes('terima')) continue;
      if (cleanFilter === 'ditolak' && !sLower.includes('tolak')) continue;
    }
    
    // Filter Search
    if (cleanSearch) {
      const matchNama  = nama.toLowerCase().includes(cleanSearch);
      const matchOrtu  = ortu.toLowerCase().includes(cleanSearch);
      const matchWa    = wa.toLowerCase().includes(cleanSearch);
      const matchKelas = kelas.toLowerCase().includes(cleanSearch);
      if (!matchNama && !matchOrtu && !matchWa && !matchKelas) continue;
    }
    
    list.push({ id, timestamp, nama, usia, ortu, wa, kelas, status });
  }
  
  // Urutkan dari yang terbaru (bottom-up index spreadsheet)
  list.reverse();
  
  const start = (page - 1) * limit;
  const paginated = list.slice(start, start + limit);
  const totalPages = Math.ceil(list.length / limit) || 1;
  
  return {
    ppdbList: paginated,
    total: list.length,
    page: page,
    totalPages: totalPages,
    stats: stats
  };
}

function updatePPDBStatus(sessionToken, ppdbId, status) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet = getSheet('PPDB');
  if (!sheet) throw new Error('Sheet PPDB tidak ditemukan');
  
  const data = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (String(data[i][0]) === String(ppdbId)) {
      sheet.getRange(i + 1, 8).setValue(status);
      const session = validateSession(sessionToken);
      logAudit(session ? session.userId : 'ADMIN', 'UPDATE_PPDB_STATUS', 'PPDB ID: ' + ppdbId + ' -> ' + status, sessionToken);
      return { success: true, status: status };
    }
  }
  throw new Error('Data PPDB tidak ditemukan');
}

function deletePPDB(sessionToken, ppdbId) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const sheet = getSheet('PPDB');
  if (!sheet) throw new Error('Sheet PPDB tidak ditemukan');
  
  const data = sheet.getDataRange().getValues();
  for (let i = 1; i < data.length; i++) {
    if (String(data[i][0]) === String(ppdbId)) {
      sheet.deleteRow(i + 1);
      const session = validateSession(sessionToken);
      logAudit(session ? session.userId : 'ADMIN', 'DELETE_PPDB', 'PPDB ID: ' + ppdbId, sessionToken);
      return { success: true };
    }
  }
  throw new Error('Data PPDB tidak ditemukan');
}

// ==================== AUDIT LOG (ADMIN) ====================
function getAuditLogs(sessionToken, page, limit, searchQuery) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  page = page || 1;
  limit = limit || 15;
  
  const sheet = getSheet('AuditLog');
  if (!sheet) return { logs: [], total: 0, page: 1, totalPages: 1 };
  
  const data = sheet.getDataRange().getValues();
  const logs = [];
  const cleanSearch = String(searchQuery || '').trim().toLowerCase();
  
  for (let i = 1; i < data.length; i++) {
    if (!data[i][0] && !data[i][1]) continue;
    
    const id        = String(data[i][0] || '');
    const userId    = String(data[i][1] || '');
    const action    = String(data[i][2] || '');
    const details   = String(data[i][3] || '');
    const ipAddress = String(data[i][4] || '');
    const userAgent = String(data[i][5] || '');
    const timestamp = data[i][6] ? new Date(data[i][6]).toLocaleString('id-ID') : '';
    
    if (cleanSearch) {
      const matchUser    = userId.toLowerCase().includes(cleanSearch);
      const matchAction  = action.toLowerCase().includes(cleanSearch);
      const matchDetails = details.toLowerCase().includes(cleanSearch);
      const matchTime    = timestamp.toLowerCase().includes(cleanSearch);
      if (!matchUser && !matchAction && !matchDetails && !matchTime) continue;
    }
    
    logs.push({ id, userId, action, details, ipAddress, userAgent, timestamp });
  }
  
  logs.reverse();
  
  const start = (page - 1) * limit;
  const paginated = logs.slice(start, start + limit);
  const totalPages = Math.ceil(logs.length / limit) || 1;
  
  return {
    logs: paginated,
    total: logs.length,
    page: page,
    totalPages: totalPages
  };
}

// ==================== NOTIFICATIONS MANAGEMENT (ADMIN) ====================
function getAdminNotifications(sessionToken, page, limit, isReadFilter) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  page = page || 1;
  limit = limit || 10;
  
  const session = validateSession(sessionToken);
  const sheet   = getSheet('Notifications');
  if (!sheet) return { notifications: [], total: 0, unreadCount: 0, page: 1, totalPages: 1 };
  
  const data  = sheet.getDataRange().getValues();
  const list  = [];
  let unreadCount = 0;
  
  for (let i = 1; i < data.length; i++) {
    if (!data[i][0]) continue;
    const isDeleted = data[i][6] === true || String(data[i][6]).toLowerCase() === 'true';
    if (isDeleted) continue;
    
    const notifUserId = String(data[i][1] || '');
    // Tampilkan notifikasi untuk admin ini atau notifikasi broadcast ke admin ('ADMIN')
    if (notifUserId && notifUserId !== session.userId && notifUserId !== 'ADMIN') continue;
    
    const isRead = data[i][5] === true || String(data[i][5]).toLowerCase() === 'true';
    if (!isRead) unreadCount++;
    
    if (isReadFilter === 'unread' && isRead) continue;
    if (isReadFilter === 'read' && !isRead) continue;
    
    list.push({
      id: String(data[i][0]),
      userId: notifUserId,
      title: String(data[i][2] || ''),
      message: String(data[i][3] || ''),
      type: String(data[i][4] || ''),
      isRead: isRead,
      createdAt: data[i][7] ? new Date(data[i][7]).toLocaleString('id-ID') : '',
      relatedId: String(data[i][8] || '')
    });
  }
  
  list.reverse();
  
  const start = (page - 1) * limit;
  const paginated = list.slice(start, start + limit);
  const totalPages = Math.ceil(list.length / limit) || 1;
  
  return {
    notifications: paginated,
    total: list.length,
    unreadCount: unreadCount,
    page: page,
    totalPages: totalPages
  };
}

// ==================== SESSIONS MANAGEMENT (ADMIN) ====================
function getSessionsAdmin(sessionToken, page, limit) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  page = page || 1;
  limit = limit || 10;
  
  const sheet = getSheet('Sessions');
  if (!sheet) return { sessions: [], total: 0, activeCount: 0, page: 1, totalPages: 1 };
  
  const data = sheet.getDataRange().getValues();
  const list = [];
  const now = new Date().getTime();
  let activeCount = 0;
  
  for (let i = 1; i < data.length; i++) {
    if (!data[i][0]) continue;
    const tokenStr  = String(data[i][0] || '');
    const userId    = String(data[i][1] || '');
    const role      = String(data[i][2] || '');
    const email     = String(data[i][3] || '');
    const expires   = Number(data[i][4] || 0);
    const createdAt = data[i][5] ? new Date(data[i][5]).toLocaleString('id-ID') : '';
    
    const isExpired = now > expires;
    if (!isExpired) activeCount++;
    
    list.push({
      token: tokenStr,
      userId: userId,
      role: role,
      email: email,
      expires: expires,
      expiresFormatted: expires ? new Date(expires).toLocaleString('id-ID') : '-',
      createdAt: createdAt,
      isExpired: isExpired,
      isCurrentSession: tokenStr === String(sessionToken).trim()
    });
  }
  
  list.reverse();
  
  const start = (page - 1) * limit;
  const paginated = list.slice(start, start + limit);
  const totalPages = Math.ceil(list.length / limit) || 1;
  
  return {
    sessions: paginated,
    total: list.length,
    activeCount: activeCount,
    page: page,
    totalPages: totalPages
  };
}

function revokeSessionAdmin(sessionToken, targetToken) {
  if (!hasPermission(sessionToken, 'admin')) throw new Error('Akses ditolak');
  const cleanTarget = String(targetToken || '').trim();
  
  try { CacheService.getScriptCache().remove(cleanTarget); } catch(e) {}
  
  const sheet = getSheet('Sessions');
  if (sheet) {
    const data = sheet.getDataRange().getValues();
    for (let i = 1; i < data.length; i++) {
      if (String(data[i][0] || '').trim() === cleanTarget) {
        sheet.deleteRow(i + 1);
        const session = validateSession(sessionToken);
        logAudit(session ? session.userId : 'ADMIN', 'REVOKE_SESSION', 'Target token: ' + cleanTarget, sessionToken);
        return { success: true, message: 'Sesi berhasil dihentikan' };
      }
    }
  }
  return { success: true, message: 'Sesi dihentikan' };
}


// =====================================================
// PANDUAN SETUP (BACA INI!)
// =====================================================
/*
=======================================================
CHECKLIST AGAR SEMUA FITUR BEKERJA
=======================================================

1. TAMBAH SHEET "PPDB" di Google Spreadsheet
   - Buat sheet baru bernama: PPDB
   - Header (baris 1): ID | Timestamp | Nama Santri | Usia | Nama Ortu/Wali | No. WhatsApp | Kelas Diminati | Status
   - (atau biarkan saja, akan dibuat otomatis oleh fungsi submitPPDB di atas)

2. DEPLOYMENT SETTINGS (paling penting!)
   - Buka Apps Script → Deploy → Manage deployments
   - Edit deployment yang aktif:
     ✅ Execute as: Me (nama akun Google kamu)
     ✅ Who has access: Anyone
   - Klik Deploy → Copy URL baru
   - Paste URL tersebut ke variabel GAS_BASE_URL di index.html

3. KONEKSI SPREADSHEET
   - Pastikan SPREADSHEET_ID di Kode.gs sudah benar
   - Sheet yang harus ada:
     ✅ ContentManager
     ✅ Users
     ✅ Santri
     ✅ Classes
     ✅ Payments
     ✅ PaymentVerifications
     ✅ Notifications
     ✅ StudentProgress
     ✅ AuditLog
     ✅ PPDB  ← baru

4. ISI ContentManager SHEET
   Kolom: key | value | type | updated_at
   
   Data yang dibutuhkan index.html:
   - home_tagline          → "Saung Quran Rabbani"
   - whatsapp_link         → "https://wa.me/6289677082002"
   - stat_total_santri     → "150+"
   - stat_pengajar         → "8+"
   - stat_tahun            → "7th"
   - keunggulan_list       → ["Pengajar berpengalaman","Metode UMMI","dll"] (JSON array)
   - sanlat_active         → "true" atau "false"
   - kajian_active         → "true" atau "false"
   - berbagi_active        → "true" atau "false"
   - jadwal_anak           → "Senin - Kamis 15.30-17.00, Sabtu 08.00-10.00"
   - jadwal_remaja         → "Selasa & Kamis 16.00-17.30, Sabtu 10.00-12.00"
   - jadwal_dewasa         → "Rabu & Jumat 19.30-21.00, Ahad 08.30-10.00"
   - biaya_spp             → "Rp 100.000"
   - mengapa_sqr           → (deskripsi SQR)
   - kajian_judul          → (judul kajian terbaru)
   - kajian_pemateri       → (nama pemateri)
   - kajian_waktu          → (waktu kajian)
   - kajian_media          → "Google Meet / YouTube Live"
   - faq_list              → [{"q":"Pertanyaan","a":"Jawaban"}] (JSON array)
   - timeline_milestones   → [{"year":"2019","desc":"SQR didirikan"}] (JSON array)
   - sanlat_title          → "YOOK GASS IKUT!!"
   - sanlat_subtitle       → (tema sanlat)
   - sanlat_pemateri       → (nama pemateri)
   - sanlat_pemateri_desc  → (deskripsi pemateri)
   - sanlat_target         → "Usia 7-15 tahun"
   - sanlat_waktu          → "Sabtu, 7 Maret 2026\n10.00 – 17.30 WIB\nSQR Pusat"
   - sanlat_harga_umum     → "35rb"
   - sanlat_harga_santri   → "15rb"
   - sanlat_kegiatan       → ["Tilawah","Hafalan","dll"] (JSON array)
   - jumat_berbagi_desc    → (deskripsi program jumat berbagi)
   - ramadhan_berbagi_desc → (deskripsi program ramadhan)

5. TEST LOKAL
   - Buka URL deployment (bukan /dev, tapi yang /exec)
   - Coba isi form PPDB → cek sheet PPDB
   - Coba login → pastikan redirect ke dashboard

=======================================================
MASALAH UMUM & SOLUSI
=======================================================

❌ "google.script.run is not defined"
   ✅ Pastikan kamu buka via URL /exec, bukan langsung file HTML

❌ Navbar active tidak berubah
   ✅ Sudah diperbaiki di index.html baru dengan scroll listener + requestAnimationFrame

❌ Animasi tidak jalan
   ✅ Sudah diperbaiki: AOS.init() dipanggil SETELAH konten dimuat + AOS.refresh()

❌ Section tidak muncul/tersembunyi
   ✅ Periksa nilai sanlat_active, kajian_active, berbagi_active di sheet ContentManager
   ✅ Harus berisi string "true" atau "false" (huruf kecil)

❌ Form PPDB: "Gagal mengirim"
   ✅ Pastikan fungsi submitPPDB() sudah ditambahkan ke Kode.gs
   ✅ Deploy ulang setelah menambahkan fungsi baru
*/



function include(filename) {
  return HtmlService.createHtmlOutputFromFile(filename).getContent();
}