const express = require('express');
const mongoose = require('mongoose');
const path = require('path');
require('dotenv').config();
const fs = require('fs');
const logger = require('./config/logger');
const morgan = require('morgan');
const multer = require('multer');
const Image = require('./models/Image');

const app = express();

// Logging middleware
app.use(morgan('combined', { stream: logger.stream }));

// Error logging middleware
app.use((err, req, res, next) => {
    logger.error('Unhandled Error:', {
        error: err.message,
        stack: err.stack,
        url: req.url,
        method: req.method,
        body: req.body,
        query: req.query,
        params: req.params,
        headers: req.headers,
        ip: req.ip
    });
    res.status(500).json({ error: 'Something broke!' });
});

// Request logging middleware
app.use((req, res, next) => {
    logger.info('Incoming Request:', {
        url: req.url,
        method: req.method,
        body: req.body,
        query: req.query,
        params: req.params,
        ip: req.ip
    });
    next();
});

app.use(express.json());
app.use(express.static('public'));
app.use('/admin', express.static(path.join(__dirname, 'admin')));

// MongoDB connection using environment variables
mongoose.connect(process.env.DB_URI, {
    useNewUrlParser: true,
    useUnifiedTopology: true
}).then(() => {
    logger.info('Connected to MongoDB successfully');
}).catch((error) => {
    logger.error('MongoDB connection error:', error);
});

// Outreach Program Schema
const OutreachSchema = new mongoose.Schema({
    name: String,
    location: String,
    imageUrl: String,
    studentsReached: Number,
    lastVisit: Date,
    nextVisit: Date,
    type: String, // 'school', 'community', or 'rural'
    description: String
});

const Outreach = mongoose.model('Outreach', OutreachSchema);

// Volunteer Schema
const VolunteerSchema = new mongoose.Schema({
    firstName: String,
    lastName: String,
    email: String,
    phone: String,
    occupation: String,
    availability: [String], // days available
    interests: [String], // areas of interest
    experience: String,
    status: {
        type: String,
        enum: ['pending', 'approved', 'active', 'inactive'],
        default: 'pending'
    },
    appliedDate: {
        type: Date,
        default: Date.now
    }
});

const Volunteer = mongoose.model('Volunteer', VolunteerSchema);

// Serve admin dashboard
app.get('/admin', (req, res) => {
    res.sendFile(path.join(__dirname, 'admin', 'dashboard.html'));
});

// Ensure all API routes start with /api
app.use('/api', express.Router());

// Move your admin dashboard files
// Create a directory structure like this:
// - public/
//   - images/
//   - css/
//   - js/
// - admin/
//   - dashboard.html
//   - dashboard.js
//   - styles/
//   - scripts/

// Update file paths in dashboard.html
const adminPath = path.join(__dirname, 'admin');
if (!fs.existsSync(adminPath)) {
    fs.mkdirSync(adminPath, { recursive: true });
}

// Get all programs
app.get('/api/outreach-programs', async (req, res) => {
    try {
        const programs = await Outreach.find().sort({ lastVisit: -1 });
        logger.info('Retrieved all outreach programs', { count: programs.length });
        res.json(programs);
    } catch (error) {
        logger.error('Error fetching programs:', error);
        res.status(500).json({ error: 'Error fetching programs' });
    }
});

// Get single program
app.get('/api/outreach-programs/:id', async (req, res) => {
    try {
        const program = await Outreach.findById(req.params.id);
        if (!program) return res.status(404).json({ error: 'Program not found' });
        res.json(program);
    } catch (error) {
        res.status(500).json({ error: 'Error fetching program' });
    }
});

// Create new program
app.post('/api/outreach-programs', async (req, res) => {
    try {
        const program = new Outreach(req.body);
        await program.save();
        res.status(201).json(program);
    } catch (error) {
        res.status(500).json({ error: 'Error creating program' });
    }
});

// Update program
app.put('/api/outreach-programs/:id', async (req, res) => {
    try {
        const program = await Outreach.findByIdAndUpdate(
            req.params.id,
            req.body,
            { new: true }
        );
        if (!program) return res.status(404).json({ error: 'Program not found' });
        res.json(program);
    } catch (error) {
        res.status(500).json({ error: 'Error updating program' });
    }
});

// Delete program
app.delete('/api/outreach-programs/:id', async (req, res) => {
    try {
        const program = await Outreach.findByIdAndDelete(req.params.id);
        if (!program) return res.status(404).json({ error: 'Program not found' });
        res.json({ message: 'Program deleted successfully' });
    } catch (error) {
        res.status(500).json({ error: 'Error deleting program' });
    }
});

// API endpoint to handle volunteer applications
app.post('/api/volunteers', async (req, res) => {
    try {
        const volunteer = new Volunteer(req.body);
        await volunteer.save();
        logger.info('New volunteer application received', {
            volunteerId: volunteer._id,
            email: volunteer.email
        });
        res.status(201).json({ 
            message: 'Thank you for volunteering! We will contact you soon.',
            volunteer 
        });
    } catch (error) {
        logger.error('Error submitting volunteer application:', error);
        res.status(500).json({ error: 'Error submitting volunteer application' });
    }
});

// Get all volunteers
app.get('/api/volunteers', async (req, res) => {
    try {
        const volunteers = await Volunteer.find().sort({ appliedDate: -1 });
        res.json(volunteers);
    } catch (error) {
        res.status(500).json({ error: 'Error fetching volunteers' });
    }
});

// Get single volunteer
app.get('/api/volunteers/:id', async (req, res) => {
    try {
        const volunteer = await Volunteer.findById(req.params.id);
        if (!volunteer) return res.status(404).json({ error: 'Volunteer not found' });
        res.json(volunteer);
    } catch (error) {
        res.status(500).json({ error: 'Error fetching volunteer' });
    }
});

// Update volunteer status
app.put('/api/volunteers/:id/status', async (req, res) => {
    try {
        const volunteer = await Volunteer.findByIdAndUpdate(
            req.params.id,
            { status: req.body.status },
            { new: true }
        );
        if (!volunteer) return res.status(404).json({ error: 'Volunteer not found' });
        res.json(volunteer);
    } catch (error) {
        res.status(500).json({ error: 'Error updating volunteer status' });
    }
});

// Add this before your routes
app.use((req, res, next) => {
    console.log(`${req.method} ${req.url}`);
    next();
});

// Add this after your routes
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ error: 'Something broke!' });
});

// Add this to handle 404s
app.use((req, res) => {
    res.status(404).json({ error: 'Not Found' });
});

// Configure multer for image upload
const storage = multer.diskStorage({
    destination: function (req, file, cb) {
        cb(null, 'public/uploads/gallery')
    },
    filename: function (req, file, cb) {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9)
        cb(null, uniqueSuffix + '-' + file.originalname)
    }
});

const upload = multer({ 
    storage: storage,
    fileFilter: (req, file, cb) => {
        if (file.mimetype.startsWith('image/')) {
            cb(null, true);
        } else {
            cb(new Error('Not an image! Please upload an image.'), false);
        }
    }
});

// Gallery Image Routes
app.post('/api/gallery/images', upload.single('image'), async (req, res) => {
    try {
        const imageUrl = `/uploads/gallery/${req.file.filename}`;
        const thumbnailUrl = imageUrl; // In production, generate actual thumbnail

        const image = new Image({
            title: req.body.title,
            description: req.body.description,
            category: req.body.category,
            imageUrl,
            thumbnailUrl
        });

        await image.save();
        res.status(201).json(image);
    } catch (error) {
        logger.error('Error uploading image:', error);
        res.status(500).json({ error: 'Error uploading image' });
    }
});

app.get('/api/gallery/images', async (req, res) => {
    try {
        const images = await Image.find({ active: true }).sort('-dateAdded');
        res.json(images);
    } catch (error) {
        logger.error('Error fetching images:', error);
        res.status(500).json({ error: 'Error fetching images' });
    }
});

app.delete('/api/gallery/images/:id', async (req, res) => {
    try {
        await Image.findByIdAndUpdate(req.params.id, { active: false });
        res.json({ message: 'Image deleted successfully' });
    } catch (error) {
        logger.error('Error deleting image:', error);
        res.status(500).json({ error: 'Error deleting image' });
    }
});

const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    logger.info(`Server running on port ${PORT}`);
});

// Handle uncaught exceptions
process.on('uncaughtException', (error) => {
    logger.error('Uncaught Exception:', error);
    process.exit(1);
});

// Handle unhandled promise rejections
process.on('unhandledRejection', (reason, promise) => {
    logger.error('Unhandled Rejection:', {
        reason: reason,
        promise: promise
    });
}); 