package com.gang.comms;

import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.geom.AffineTransform;
import java.awt.image.AffineTransformOp;
import java.awt.image.BufferedImage;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.Date;
import java.util.HashSet;
import java.util.Iterator;
import java.util.List;
import java.util.Set;
import java.util.UUID;

import javax.imageio.ImageIO;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileUploadException;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;
import org.apache.commons.io.FileUtils;
import org.apache.commons.io.output.DeferredFileOutputStream;
import org.apache.struts2.dispatcher.multipart.MultiPartRequestWrapper;

import sun.misc.BASE64Encoder;

import com.sun.image.codec.jpeg.JPEGCodec;
import com.sun.image.codec.jpeg.JPEGImageEncoder;

public class FileHelper {
	public static Set<String> saveFiles(List<File> files, String virtualPath, String localPath) throws IOException {
		Set<String> fns = new HashSet<String>();
		if(files==null) return null;
		for (int i = 0; i < files.size(); i++) {
			File file = files.get(i);
			if (file.exists()) {
				String newName = UUID.randomUUID().toString();
				String vname = virtualPath + newName;
				File destFile = new File(localPath + "\\" + newName);
				FileUtils.copyFile(file, destFile);
				file.delete();
				fns.add(vname);
			}
		}
		return fns;
	}
	public static Set<String> saveFiles(List<File> files, List<String> fileNames, String uploadDir, String saveDir) throws IOException {
		Set<String> fns = new HashSet<String>();

		for (int i = 0; i < files.size(); i++) {
			File file = files.get(i);
			if (file.exists()) {
				String newName = new Date().getTime() + "_" + i + getFileExt(fileNames.get(i));
				String vname = uploadDir + newName;
				File destFile = new File(saveDir + "\\" + newName);
				FileUtils.copyFile(file, destFile);
				file.delete();
				fns.add(vname);
			}
		}
		return fns;
	}
	public static String saveFiles(File file, String uploadDir, String saveDir) throws IOException {
		String vname = null;
		if (file != null && file.exists()) {
			String newName = UUID.randomUUID().toString() + getFileExt(file.getName());
			vname = uploadDir + "/" + newName;
			File destFile = new File(saveDir + "\\" + newName);
			FileUtils.copyFile(file, destFile);
			file.delete();
		}
		return vname;
	}
	public static String saveAPK(File file, String uploadDir, String saveDir) throws IOException {
		String vname = null;
		if (file != null && file.exists()) {
			String newName = UUID.randomUUID().toString() +".apk";
			vname = uploadDir + "/" + newName;
			File destFile = new File(saveDir + "\\" + newName);
			FileUtils.copyFile(file, destFile);
			file.delete();
		}
		return vname;
	}
	public static String saveFiles(File file, String fileName, String uploadDir, String saveDir) throws IOException {
		String vname = null;
		if (file != null && file.exists()) {
			String newName = UUID.randomUUID().toString() + getFileExt(fileName);
			vname = uploadDir + "/" + newName;
			File destFile = new File(saveDir + "\\" + newName);
			FileUtils.copyFile(file, destFile);
			file.delete();
		}
		return vname;
	}

	private static String getFileExt(String fileName) {
		return fileName.substring(fileName.lastIndexOf('.'));
	}

	public static String ProcessRequest(HttpServletRequest request) throws ServletException, IOException {
		BASE64Encoder encoder = new BASE64Encoder();

		byte[] bs = null;
		long filesize = 0;

		DiskFileItemFactory factory = new DiskFileItemFactory();

		int width = 0;
		int height = 0;

		InputStream inputStream = null;
		ByteArrayOutputStream op = null;
		DeferredFileOutputStream dfo = null;

		try {
			factory.setSizeThreshold(4096);// 设置缓冲,这个值决定了是fileinputstream还是bytearrayinputstream
			factory.setRepository(new File("e:\\green\\tomcat6.0\\webapps\\evaluation\\temp"));// 设置临时存放目录,默认是new
																								// File(System.getProperty("java.io.tmpdir"))
			ServletFileUpload sfileUpLoad = new ServletFileUpload(factory);
			sfileUpLoad.setSizeMax(10 * 1024 * 1024);// 10M
			List<?> items = sfileUpLoad.parseRequest(request);
			Iterator<?> it = items.iterator();
			// 暂时只考虑单文件
			while (it.hasNext()) {
				FileItem fileItem = (FileItem) it.next();
				if (!fileItem.isFormField()) {
					inputStream = fileItem.getInputStream();
					filesize = fileItem.getSize();
					bs = new byte[(int) filesize];

				} else {
					if (fileItem.getFieldName().equals("width")) {
						dfo = (DeferredFileOutputStream) fileItem.getOutputStream();
						width = Integer.parseInt(new String(dfo.getData()));
					}
					if (fileItem.getFieldName().equals("height")) {
						dfo = (DeferredFileOutputStream) fileItem.getOutputStream();
						height = Integer.parseInt(new String(dfo.getData()));
					}
				}
			}
			// 上面是没有struts的情况
			// 下面是为了和struts兼容
			if (inputStream == null) {
				MultiPartRequestWrapper multiPartRequest = (MultiPartRequestWrapper) request;
				if (multiPartRequest != null) {
					File f = multiPartRequest.getFiles("file")[0];
					inputStream = new FileInputStream(f);

				}
				width = 200;
				height = 55;
			}
			op = ResizeImg(inputStream, width, height);

			bs = op.toByteArray();

			String imgpath = "data:image/jpeg;base64,";
			String img = encoder.encode(bs);

			imgpath += img;

			return imgpath;
		} catch (FileUploadException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			if (dfo != null) {
				dfo.close();
			}
			if (inputStream != null) {
				inputStream.close();
			}
			if (op != null) {
				op.close();
			}
		}

		// blankimage
		return "data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==";

	}

	/**
	 * @param inputStream
	 * @param maxWidth
	 * @param maxHeight
	 * @return 只对jpg缩放
	 * @throws IOException
	 */
	public static ByteArrayOutputStream ResizeImg(InputStream inputStream, int maxWidth, int maxHeight) throws IOException {

		BufferedImage bufferimage = ImageIO.read(inputStream);
		int curWidth = bufferimage.getWidth();
		int curHeight = bufferimage.getHeight();

		// double desiredRatio =
		// Math.min((double)(maxWidth)/(double)curWidth,(double)maxHeight/(double)curHeight);
		// curWidth = (int) (curWidth*desiredRatio);
		// curHeight = (int)(curHeight*desiredRatio);
		double ratio = 0;
		Image itemp = bufferimage.getScaledInstance(maxWidth, maxHeight, bufferimage.SCALE_SMOOTH);
		// 计算比例
		if ((bufferimage.getHeight() > maxHeight) || (bufferimage.getWidth() > maxWidth)) {
			if (bufferimage.getHeight() > bufferimage.getWidth()) {
				ratio = (new Integer(maxHeight)).doubleValue() / bufferimage.getHeight();
			} else {
				ratio = (new Integer(maxWidth)).doubleValue() / bufferimage.getWidth();
			}
			AffineTransformOp op = new AffineTransformOp(AffineTransform.getScaleInstance(ratio, ratio), null);
			itemp = op.filter(bufferimage, null);
		}

		BufferedImage bufftmp = new BufferedImage(curWidth, curHeight, BufferedImage.TYPE_INT_RGB);
		Graphics2D g2D = bufftmp.createGraphics();

		g2D.setColor(Color.white);
		g2D.fillRect(0, 0, curWidth, curHeight);
		// g2D.drawImage(bufferimage, null, 0, 0);

		if (maxWidth == itemp.getWidth(null))
			g2D.drawImage(itemp, 0, (maxHeight - itemp.getHeight(null)) / 2, itemp.getWidth(null), itemp.getHeight(null), Color.white, null);
		else
			g2D.drawImage(itemp, (maxWidth - itemp.getWidth(null)) / 2, 0, itemp.getWidth(null), itemp.getHeight(null), Color.white, null);
		g2D.dispose();
		// itemp = bufftmp;

		ByteArrayOutputStream op = new ByteArrayOutputStream();

		JPEGImageEncoder imageEncoder = JPEGCodec.createJPEGEncoder(op);

		imageEncoder.encode((BufferedImage) itemp);

		return op;
	}

	public static void createFolderIfNotExists(String path) {
		File file = new File(path);
		if (!file.exists()) {
			file.mkdirs();
		}

	}

	public static void deleteFile(File file) {
		if (file.exists()) {
			if (file.isDirectory()) {
				File files[] = file.listFiles();
				for (int i = 0; i < files.length; i++) {
					deleteFile(files[i]);
				}
			}
			file.delete();
		} else {
			System.out.println("所删除的文件不存在！" + '\n');
		}
	}

}
