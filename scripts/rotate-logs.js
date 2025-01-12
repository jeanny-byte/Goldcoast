const { rotateLog } = require('../config/logrotate');
const path = require('path');

const MAX_SIZE = 5 * 1024 * 1024; // 5MB
const MAX_FILES = 5;

const logFiles = ['error.log', 'combined.log', 'debug.log'];

logFiles.forEach(file => {
    rotateLog(
        path.join(__dirname, '../logs', file),
        MAX_SIZE,
        MAX_FILES
    );
}); 