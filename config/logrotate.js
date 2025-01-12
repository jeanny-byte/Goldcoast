const fs = require('fs');
const path = require('path');
const logger = require('./logger');

function rotateLog(logFile, maxSize, maxFiles) {
    try {
        const stats = fs.statSync(logFile);
        if (stats.size > maxSize) {
            for (let i = maxFiles - 1; i > 0; i--) {
                const fromFile = i === 1 ? logFile : `${logFile}.${i - 1}`;
                const toFile = `${logFile}.${i}`;
                if (fs.existsSync(fromFile)) {
                    fs.renameSync(fromFile, toFile);
                }
            }
            fs.renameSync(logFile, `${logFile}.1`);
            fs.writeFileSync(logFile, '');
            logger.info(`Rotated log file: ${logFile}`);
        }
    } catch (error) {
        logger.error('Error rotating log file:', error);
    }
}

module.exports = { rotateLog }; 